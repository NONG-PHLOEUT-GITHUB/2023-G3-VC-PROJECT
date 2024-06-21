<template>
  <custom-title icon="mdi-human-male-girl">
    <template #right>
      <v-btn
        variant="outlined"
        append-icon="mdi-filter-multiple-outline"
        class="text-none me-4"
        color="primary"
        @click="toggleFilter = !toggleFilter"
      >
        {{ $t('btn.filter') }}
      </v-btn>
      <v-btn
        variant="tonal"
        class="bg-green-darken-1"
        icon="mdi-file-excel"
        @click="exportExcel()"
      ></v-btn>
      <v-btn
        :disabled="this.selectedItem.length <= 0"
        variant="tonal"
        class="ms-4 bg-error"
        icon="mdi-delete-forever"
        @click="deleteMultiple"
      ></v-btn>
    </template>
  </custom-title>
  <v-slide-y-reverse-transition mode="in-out">
    <filter-guardian v-show="toggleFilter" @filter-guardian="onFilterGuardian" />
  </v-slide-y-reverse-transition>
  <v-data-table
    v-model="selectedItem"
    :headers="headers"
    :items="guardians"
    :loading="loading"
    item-value="id"
    show-select
    class="elevation-0"
    hover
  >
    <template v-slot:item.profile="{ item }">
      <v-avatar size="large">
        <v-img :src="item.profile" alt="Avatar" cover></v-img>
      </v-avatar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-btn
        :to="{ path: '/guardian/' + item.id + '/edit' }"
        variant="text"
        icon="mdi-pencil"
        color="btnEdit"
      ></v-btn>

      <v-btn
        @click="removeGuardian(item.id)"
        variant="text"
        icon="mdi-delete-forever"
        color="red"
      ></v-btn>
    </template>
  </v-data-table>
</template>

<script>
  import FilterGuardian from '@/components/filters/FilterGuardian.vue'
  import { mapActions, mapState } from 'pinia'
  import { useGuardianStore } from '@/stores/guardian'
  import http from '@/api/api'
  export default {
    components: {
      FilterGuardian
    },
    created() {
      this.getAllGuardian(this.filterCriteria)
    },
    data() {
      return {
        selectedItem: [],
        loading: false,
        toggleFilter: false,
        filterCriteria: {},
        headers: [
          {
            title: 'First name',
            align: 'start',
            sortable: false,
            key: 'first_name'
          },
          {
            title: 'Last name',
            align: 'start',
            key: 'last_name'
          },
          {
            title: 'Gender',
            key: 'gender',
            sortable: false,
            align: 'end'
          },
          {
            title: 'Phone number',
            key: 'phone_number',
            align: 'end'
          },
          {
            title: 'Telegram',
            key: 'chat_id',
            align: 'end',
            sortable: false
          },
          { title: '', key: 'actions', align: 'end' }
        ]
      }
    },
    computed: {
      ...mapState(useGuardianStore, ['guardians'])
    },
    methods: {
      ...mapActions(useGuardianStore, [
        'getAllGuardian',
        'deleteGuardianByID',
        'deleteMultipleGuardians'
      ]),
      removeGuardian(id) {
        this.$root.$confirm({
          title: 'Are you sure?',
          message: 'Are you sure you want to delete this guardian?',
          options: {
            agreeBtnText: 'Yes',
            type: 'error',
            color: 'error',
            width: 400
          },
          agree: () =>
            this.deleteGuardianByID(id).then(response => {
              if (response.status == 200) {
                this.$root.$notif(this.$t('alert.delete'), {
                  type: 'success',
                  color: 'primary'
                })
              }
              this.getAllGuardian(this.filterCriteria)
            })
        })
      },
      deleteMultiple() {
        this.$root.$confirm({
          title: 'Are you sure?',
          message: 'Are you sure you want to delete these guardians?',
          options: {
            agreeBtnText: 'Yes',
            type: 'error',
            color: 'error',
            width: 400
          },
          agree: () =>
            this.deleteMultipleGuardians(this.selectedItem).then(response => {
              if (response.status == 200) {
                this.$root.$notif(this.$t('alert.delete'), {
                  type: 'success',
                  color: 'primary'
                })
                this.getAllGuardian(this.filterCriteria)
              }
              this.selectedItem = []
            })
        })
      },
      onFilterGuardian(filterText) {
        this.filterCriteria = filterText
        this.getAllGuardian(this.filterCriteria)
      },
      exportExcel() {
        http
          .get(`guardians/export-excel`, {
            responseType: 'blob'
          })
          .then(response => {
            // Create a Blob from the response data
            const blob = new Blob([response.data], {
              type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            })
            const url = window.URL.createObjectURL(blob)
            // Get the current date and format it
            const date = new Date()
            const day = String(date.getDate()).padStart(2, '0')
            const month = String(date.getMonth() + 1).padStart(2, '0') // Months are zero-based
            const year = date.getFullYear()
            const formattedDate = `${day}_${month}_${year}`
            // Create a link element to trigger the download
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download', `${formattedDate}_parent.xlsx`) // Adjust filename as needed

            // Append the link to the document body and trigger the click event
            document.body.appendChild(link)
            link.click()

            // Clean up by revoking the Object URL
            window.URL.revokeObjectURL(url)
          })
          .catch(error => {
            console.error('Error downloading Excel file:', error)
            // Handle error if needed
          })
      },
    }
  }
</script>

<template>
  <custom-title icon="mdi-account-school-outline">
    <template #right>
      <div>
        <v-tooltip activator="parent" text="Import Excel" location="top">
          <template v-slot:activator="{ props }">
            <v-btn
              v-bind="props"
              variant="tonal"
              class="me-4 bg-secondary"
              size="small"
              icon="mdi-database-import"
              @click="isEmport = !isEmport"
            ></v-btn>
          </template>
        </v-tooltip>
      </div>
      <div>
        <v-tooltip activator="parent" text="Export Excel" location="top">
          <template v-slot:activator="{ props }">
            <v-btn
              v-bind="props"
              variant="tonal"
              @click="exportExcel()"
              class="bg-green-darken-1"
              icon="mdi-database-export"
              size="small"
            ></v-btn>
          </template>
        </v-tooltip>
      </div>
      <v-btn
        :disabled="this.selectedUser.length <= 0"
        variant="tonal"
        class="ms-4 bg-error"
        icon="mdi-delete-forever"
        @click="deleteMultiple"
        size="small"
      ></v-btn>
      <v-btn
        variant="outlined"
        append-icon="mdi-filter-multiple-outline"
        class="text-none ms-4"
        color="primary"
        @click="toggleFilter = !toggleFilter"
      >
        {{ $t('btn.filter') }}
      </v-btn>
      <v-btn
        append-icon="mdi-plus"
        class="text-none ms-4"
        color="primary"
        :to="{ path: '/create-user' }"
      >
        {{ $t('btn.create') }}
      </v-btn>
    </template>
  </custom-title>
  <v-expand-transition>
    <v-card class="pa-0" v-show="isEmport">
      <v-form @submit.prevent="importUserExcelFile">
        <v-row cols="4" class="pa-2">
          <v-col>
            <v-file-input
              label="Upload Excel file"
              variant="outlined"
              prepend-icon=""
              prepend-inner-icon="mdi-paperclip"
              hide-details
              density="compact"
              v-model="chosenFile"
            ></v-file-input>
          </v-col>
          <v-col>
            <v-btn type="submit" class="text-none bg-primary">Upload</v-btn>
          </v-col>
        </v-row>
      </v-form>
    </v-card>
  </v-expand-transition>
  <v-slide-y-reverse-transition mode="in-out">
    <filter-user v-show="toggleFilter" @filter-user="onFilterApplied" />
  </v-slide-y-reverse-transition>
  <v-data-table
    v-model="selectedUser"
    :headers="headers"
    :items="students"
    :loading="loading"
    item-value="id"
    show-select
    hover
    class="elevation-0"
  >
    <template v-slot:item.profile="{ item }">
      <v-avatar size="large" v-if="item.profile">
        <v-img :src="item.profile" alt="Avatar" cover></v-img>
      </v-avatar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-btn
        :to="{ path: '/user/' + item.id + '/edit' }"
        variant="text"
        icon="mdi-pencil"
        color="btnEdit"
      ></v-btn>

      <v-btn
        @click="deleteStudentFromList(item.id)"
        variant="text"
        icon="mdi-delete-forever"
        color="error"
      ></v-btn>
      <v-btn
        :to="{ path: '/student/' + item.id + '/details' }"
        icon="mdi-eye"
        variant="text"
      ></v-btn>
    </template>
  </v-data-table>
</template>
<script>
  import FilterUser from '@/components/filters/FilterUser.vue'
  import http from '@/api/api'
  import { mapActions, mapState } from 'pinia'
  import { useStudentStore } from '@/stores/student'
  export default {
    components: {
      FilterUser
    },
    data() {
      return {
        selectedUser: [],
        errorMessage: '',
        chosenFile: null,
        toggleFilter: false,
        isEmport: false,
        loading: false,
        filterCriteria: {},
        headers: [
          { title: '#ID', key: 'id', width: '2px' },
          { title: 'Profile', key: 'profile' },
          { title: 'First Name', key: 'first_name' },
          { title: 'Last Name', key: 'last_name' },
          { title: 'Gender', key: 'gender' },
          { title: 'Phone Number', key: 'phone_number' },
          { title: 'Email', key: 'email' },
          { title: '', key: 'actions', width: '16%' }
        ]
      }
    },
    created() {
      this.getStudents(this.filterCriteria)
    },
    computed: {
      ...mapState(useStudentStore, ['students'])
    },
    methods: {
      ...mapActions(useStudentStore, [
        'getStudents',
        'deleteStudent',
        'deleteMultipleUsers'
      ]),

      deleteStudentFromList(id) {
        this.$root.$confirm({
          title: this.$t('alert.confirm'),
          message: this.$t('alert.message'),
          options: {
            agreeBtnText: 'Yes',
            type: 'error',
            color: 'error',
            width: 400
          },
          agree: () =>
            this.deleteStudent(id).then(response => {
              if (response.status == 200) {
                this.$root.$notif(this.$t('alert.delete'), {
                  type: 'success',
                  color: 'primary'
                })
              }
              this.getStudents()
            })
        })
      },

      deleteMultiple() {
        this.$root.$confirm({
          title: 'Are you sure?',
          message: 'Are you sure you want to delete these students?',
          options: {
            agreeBtnText: 'Yes',
            type: 'error',
            color: 'error',
            width: 400
          },
          agree: () =>
            this.deleteMultipleUsers(this.selectedUser).then(response => {
              if (response.status == 200) {
                this.$root.$notif(this.$t('alert.delete'), {
                  type: 'success',
                  color: 'primary'
                })
                this.selectedUser = []
              }
              this.getStudents()
            })
        })
      },

      exportExcel() {
        http
          .get(`users/students/export-excel`, {
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
            link.setAttribute('download', `${formattedDate}_student_list.xlsx`) // Adjust filename as needed

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

      importUserExcelFile() {
        const formData = new FormData()
        formData.append('file', this.chosenFile)
        http
          .post('/users/import', formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
              'Cache-Control': 'no-cache'
            }
          })
          .then(() => {
            this.$root.$notif(this.$t('Upload successfully'), {
              type: 'success',
              color: 'primary'
            })
            this.chosenFile = null
            this.getStudents(this.filterCriteria)
          })
          .catch(error => {
            this.$root.$notif(this.$t(error), {
              type: 'success',
              color: 'primary'
            })
          })
      },
      onFilterApplied(filterText) {
        this.filterCriteria = filterText
        this.getStudents(this.filterCriteria)
      }
    }
  }
</script>

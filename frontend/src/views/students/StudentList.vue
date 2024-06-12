<template>
  <custom-title icon="mdi-account-school-outline">
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
        append-icon="mdi-plus"
        class="text-none me-4"
        color="primary"
        :to="{ path: '/create-user' }"
      >
        {{ $t('btn.create') }}
      </v-btn>
      <div>
        <v-tooltip activator="parent" text="Import Excel" location="top">
          <template v-slot:activator="{ props }">
            <v-btn
              v-bind="props"
              variant="tonal"
              class="me-4 bg-deep-orange-accent-4"
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
              class="me-4 bg-green-darken-1"
              icon="mdi-database-export"
            ></v-btn>
          </template>
        </v-tooltip>
      </div>
      <v-btn
        v-if="this.selectedUser.length > 0"
        variant="tonal"
        class="bg-deep-orange-accent-4"
        icon="mdi-delete-forever"
        @click="deleteMultiple"
      ></v-btn>
    </template>
  </custom-title>
  <v-expand-transition>
    <v-card class="mb-3 pa-0" v-show="isEmport">
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
            ></v-file-input>
          </v-col>
          <v-col>
            <v-btn type="submit">Send</v-btn>
          </v-col>
        </v-row>
      </v-form>
    </v-card>
  </v-expand-transition>
  <v-slide-y-reverse-transition mode="in-out">
    <filter-user v-show="toggleFilter" @filter-user="onFilterApplied" />
  </v-slide-y-reverse-transition>
  <v-card>
    <v-data-table
      v-model="selectedUser"
      :headers="headers"
      :items="students"
      :loading="loading"
      item-value="id"
      id="my-table"
      show-select
      hover
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
        ></v-btn>

        <v-btn
          @click="deleteStudentFromList(item.id)"
          variant="text"
          icon="mdi-delete-forever"
          color="red"
        ></v-btn>
        <v-btn
          :to="{ path: '/student/' + item.id + '/details' }"
          icon="mdi-eye"
          variant="text"
        ></v-btn>
      </template>
    </v-data-table>
  </v-card>
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
          message: this.$t('alert.areYouSure'),
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

            // Create a link element to trigger the download
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download', 'student.xlsx') // Adjust filename as needed

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
        const file = this.$refs.fileInput.files[0]
        const formData = new FormData()
        formData.append('file', file)
        http
          .post('/users-import', formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
              'Cache-Control': 'no-cache'
            }
          })
          .then(response => {
            console.log(response.data)
            // Reset the file input field
            this.$refs.fileInput.value = ''
            // call mounted
            this.getStudents(this.filterCriteria)
          })
          .catch(error => {
            console.error(error.response.data)
          })
      },
      onFilterApplied(filterText) {
        this.filterCriteria = filterText
        this.getStudents(this.filterCriteria)
      }
    }
  }
</script>

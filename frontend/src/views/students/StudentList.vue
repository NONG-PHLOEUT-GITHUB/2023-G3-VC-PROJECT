<template>
  <custom-title icon="mdi-account-school-outline">
    <template #right>
      <v-btn
        variant="outlined"
        append-icon="mdi-filter-multiple-outline"
        class="text-none me-4"
        color="primary"
        @click="toggleFilter = !toggleFilter"
        >Filters
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
      <div>
        <v-tooltip activator="parent" text="Add new" location="top">
          <template v-slot:activator="{ props }">
            <v-btn
              v-bind="props"
              :to="{ path: '/create-user' }"
              variant="tonal"
              class="bg-dark-darken-4"
              icon="mdi-database-plus"
            ></v-btn>
          </template>
        </v-tooltip>
      </div>
    </template>
  </custom-title>
  <v-expand-transition>
    <v-card class="mb-3 pa-0" v-show="isEmport">
      <v-col cols="4" class="pa-2">
        <v-file-input
          label="Upload Excel file"
          variant="outlined"
          prepend-icon=""
          prepend-inner-icon="mdi-paperclip"
          hide-details
          @submit.prevent="importFile"
        ></v-file-input>
      </v-col>
    </v-card>
  </v-expand-transition>
  <v-card>
    <v-data-table
      :headers="headers"
      :items="students"
      :loading="loading"
      item-value="name"
      id="my-table"
    >
      <template v-slot:item.profile="{ item }">
        <v-avatar size="large" v-if="item.profile">
          <v-img :src="item.profile" alt="Avatar" cover> </v-img>
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
        >
        </v-btn>
        <v-btn :to="{ path: '/student/' + item.id + '/details' }" icon="mdi-eye" variant="text">
        </v-btn>
      </template>
    </v-data-table>
  </v-card>
</template>
<script>
import http from '@/api/api'
import { mapActions, mapState } from 'pinia'
import { useStudentStore } from '@/stores/student'
export default {
  data() {
    return {
      listStudents: [],
      errorMessage: '',
      searchQuery: '',
      selectedClass: null,
      classrooms: [],
      options: {
        itemsPerPage: 10,
        page: 1,
        sortBy: [],
        sortDesc: []
      },
      isEmport: false,
      loading: false,
      headers: [
        { title: '#ID', key: 'id',width: '2px'  },
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
    this.getStudents()
  },
  computed: {
    ...mapState(useStudentStore, ['students'])
  },
  methods: {
    ...mapActions(useStudentStore, ['getStudents', 'deleteStudent']),

    deleteStudentFromList(id) {
      console.log(id)
      this.deleteStudent(id).then(response => {
        if (response.status == 200) {
          this.$root.$notif('Delete successfully', {
            type: 'success',
            color: 'primary'
          })
        }
        this.getStudents()
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

    importFile() {
      /// progressbar
      let timerInterval
      Swal.fire({
        title: 'File Uploading',
        html: 'Please wait for file upload <b></b> %.',
        timer: 2000, // Change the timer to 5000ms (5 seconds)
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading()
          const b = Swal.getHtmlContainer().querySelector('b')
          let startTime = Date.now()
          timerInterval = setInterval(() => {
            let elapsedTime = Date.now() - startTime
            let progress = Math.min(100, Math.round(elapsedTime / 20))
            b.textContent = progress
          }, 20)
        },
        willClose: () => {
          clearInterval(timerInterval)
        }
      }).then(result => {
        if (result.dismiss === Swal.DismissReason.timer) {
          console.log('I was closed by the timer')
        }
      })
      /// data upload

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
          this.getStudents()
        })
        .catch(error => {
          console.error(error.response.data)
        })
    }
  }
}
</script>

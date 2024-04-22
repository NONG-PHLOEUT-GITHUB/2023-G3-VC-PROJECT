<template>
  <custom-title icon="mdi-account-school-outline"></custom-title>
  <v-card class="mb-3 py-3">
    <v-row>
      <v-col>
        <v-file-input
          label="Upload Excel file"
          variant="outlined"
          @submit.prevent="importFile"
          density="compact"
        ></v-file-input>
      </v-col>
      <v-col>
        <v-btn :to="{ path: '/create-user' }" color="teal-darken-4" append-icon="mdi-account-plus"
          >Add new user
        </v-btn>
      </v-col>
    </v-row>
  </v-card>
  <v-card>
    <v-data-table-server
      v-model:items-per-page="itemsPerPage"
      :headers="headers"
      :items="listUser"
      :items-length="listUser.length"
      :loading="loading"
      :search="search"
      item-value="name"
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

        <v-btn @click="deleteUser(item.id)" variant="text" icon="mdi-delete-forever" color="red">
        </v-btn>
        <v-btn :to="{ path: '/student/' + item.id + '/details' }" icon="mdi-eye" variant="text">
        </v-btn>
      </template>
    </v-data-table-server>
  </v-card>
  <div class="icon pa-4">
    <v-btn v-if="!isDownloading" @click="downloadPDF()">
      <v-icon size="24">mdi-download</v-icon>
      Download PDF
    </v-btn>
    <div v-else>
      <p>Generating PDF...</p>
      <i class="fa fa-spinner fa-spin"></i>
    </div>
    <a v-if="pdfUrl" :href="pdfUrl" download="file.pdf"></a>
  </div>
  <!-- <v-card class="card mt-5 elevation-4">
    <div class="card-header">
      <span class="mb-0 text-teal text-h5">USER LIST</span>
    </div>
    <div class="card-header">
      <div>
        <label for="validationCustom02" class="form-label"
          >Select by class</label
        >
        <select
          class="form-select mb-3"
          aria-label="Default select example"
          style="width: 30%"
          v-model="selectedClass"
          @click="getStudentInClass(selectedClass)"
        >
          <option value="noChoose">All class</option>
          <option
            v-for="classroom in classrooms"
            :key="classroom.id"
            :value="classroom.id"
          >
            {{ classroom.class_name }}
          </option>
        </select>
      </div>
  
      </div>
    </div>
   -->
</template>
<script>
import http from '@/api/api'
export default {
  data() {
    return {
      listUser: [],
      errorMessage: '',
      searchQuery: '',
      selectedClass: null,
      classrooms: [],
      itemsPerPage: 10,
      headers: [
        { title: 'Profile', key: 'profile' },
        { title: 'First Name', key: 'first_name' },
        { title: 'Last Name', key: 'last_name' },
        { title: 'Gender', key: 'gender' },
        { title: 'Age', key: 'age', width: '5' },
        { title: 'Phone Number', key: 'phone_number' },
        { title: 'Address', key: 'address' },
        { title: 'Email', key: 'email' },
        { title: '', key: 'actions', width: '14%' }
      ]
    }
  },

  computed: {
    filteredStudentsList() {
      if (this.searchQuery === '') {
        return this.listUser
      } else {
        const filtered = this.listUser.filter(student =>
          (student.first_name + ' ' + student.last_name)
            .toLowerCase()
            .includes(this.searchQuery.trim().toLowerCase())
        )
        return filtered
      }
    }
  },
  methods: {
    //===================get data from Database =================
    getStudents() {
      http.get('/users').then(response => {
        this.listUser = response.data.data
      })
    },
    //================== Delete a user =================
    deleteUser(id) {
      swal({
        title: 'Are you sure?',
        text: 'You will not be able to recover this user!',
        icon: 'warning',
        buttons: ['Cancel', 'Yes, delete it!'],
        dangerMode: true
      }).then(willDelete => {
        if (willDelete) {
          http
            .delete('/delete-user' + `/${id}`)
            .then(() => {
              // call mounted
              this.getStudents()
            })
            .catch(error => {
              console.error(error)
            })
        } else {
        }
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

          /// progressbar
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: toast => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })

          Toast.fire({
            icon: 'success',
            title: 'Upload successful'
          })

          // Reset the file input field
          this.$refs.fileInput.value = ''
          // call mounted
          this.getStudents()
        })
        .catch(error => {
          console.error(error.response.data)
        })
    },
    getStudentInClass(classId) {
      http
        .get(`/users`)
        .then(response => {
          if (!this.selectedClass || this.selectedClass == 'noChoose') {
            this.listUser = response.data.data
          } else {
            this.listUser = response.data.data.filter(
              user => parseInt(user.class_room_id) === parseInt(classId)
            )
          }
        })
        .catch(error => {
          console.log(error)
        })
    },
    getClassrooms() {
      http
        .get('/classrooms')
        .then(response => {
          this.classrooms = response.data.data
        })
        .catch(error => {
          console.log('Error fetching classrooms:', error)
        })
    }
  },

  mounted() {
    this.getClassrooms()
    this.getStudentInClass()
    // this.$refs.fileInput.addEventListener("change", this.importFile);
    return this.getStudents()
  }
}
</script>

<style scoped>
.card {
  margin-left: 18%;
  margin-right: 10px;
}

.input-file {
  position: relative;
  overflow: hidden;
  border: none;
  background-color: #1d6f42;
  border-radius: 3px;
  box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.input-file:hover {
  background-color: #1d6f42;
}

.input-file [type='file'] {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  cursor: pointer;
}

.input-file label {
  color: #f1f1f1;
  cursor: pointer;
  margin-top: 2px;
}

.input-file .bi {
  color: #e2d7d7;
}

.bi-brightness-low {
  color: yellow;
}

.bi-cloud-arrow-up {
  font-size: 20px;
  margin-top: 20px;
}

.card {
  padding: 20px;
}
.thead {
  background: #004d40;
}
</style>

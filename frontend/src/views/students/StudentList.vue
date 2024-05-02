<template>
  <custom-title icon="mdi-account-school-outline">
    <template #right>
      <v-btn
        icon="mdi-filter-multiple-outline"
        variant="tonal"
        class="me-2 bg-primary"
        @click="toggleFilter = !toggleFilter"
      ></v-btn>
      <v-btn
        variant="tonal"
        class="me-2 bg-deep-orange-accent-4"
        icon="mdi-file-pdf-box"
        @click="downloadPDF()"
      ></v-btn>
      <v-btn variant="tonal" class="me-2 bg-green-darken-1" icon="mdi-file-excel"></v-btn>
    </template>
  </custom-title>
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
    <v-data-table
      v-model:items-per-page="options.itemsPerPage"
      v-model:page="options.page"
      :headers="headers"
      :items="students"
      :items-length="students.length"
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

        <v-btn @click="deleteUser(item.id)" variant="text" icon="mdi-delete-forever" color="red">
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
  created() {
    this.getStudents()
  },
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
      loading: false,
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
    ...mapState(useStudentStore, ['students']),
  },
  methods: {
    ...mapActions(useStudentStore, ['getStudents']),

    //================== Delete a user =================
    // deleteUser(id) {
    //   http.delete('/delete-user' + `/${id}`)
    //         .then(() => {
    //           // call mounted
    //           this.getStudents()
    //         })
    //         .catch(error => {
    //           console.error(error)
    //         })
    //   }
    // },

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
    },
    // getStudentInClass(classId) {
    //   http
    //     .get(`/users`)
    //     .then(response => {
    //       if (!this.selectedClass || this.selectedClass == 'noChoose') {
    //         this.listUser = response.data.data
    //       } else {
    //         this.listUser = response.data.data.filter(
    //           user => parseInt(user.class_room_id) === parseInt(classId)
    //         )
    //       }
    //     })
    //     .catch(error => {
    //       console.log(error)
    //     })
    // },
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
    // this.getStudentInClass()
    return this.getStudents()
  }
}
</script>

<!-- <script>
import jsPDF from "jspdf";
import html2canvas from "html2canvas";
import http from "@/api/api";

export default {

  data() {
    return {
      isDownloading: false,
      isDetail: false,
      pdfUrl: null,
      students: [],
    };
  },
  methods: {
    downloadPDF() {
      this.isDetail = true;
      http
        .get("/get-students")
        .then((response) => {
          this.students = response.data.data;
          const element = document.getElementById("my-table");
          html2canvas(element).then((canvas) => {
            const imgData = canvas.toDataURL("image/png");
            const pdf = new jsPDF();
            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
            pdf.addImage(imgData, "JPEG", 0, 0, pdfWidth, pdfHeight);
            pdf.save("download.pdf");
            this.isDetail = false;
            this.fetchData();
          });
        })
        .catch((error) => {
          console.error(error);
        });
    },
    fetchData() {
      http
        .get("/get-students")
        .then((response) => {
          this.students = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.fetchData();
  },
};
</script> -->

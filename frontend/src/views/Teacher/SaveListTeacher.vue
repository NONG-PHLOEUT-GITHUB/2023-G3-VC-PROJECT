<template>
  <custom-title icon="mdi-human-male-board"></custom-title>
  <v-select label="Select teacher"></v-select>

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
        <v-avatar size="large">
          <v-img :src="item.profile" alt="Avatar" cover> </v-img>
        </v-avatar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-btn :to="{ path: '/user/' + item.id + '/edit' }" variant="text" icon="mdi-pencil"></v-btn>

        <v-btn @click="deleteUser(item.id)" variant="text" icon="mdi-delete-forever" color="red"> </v-btn>
      </template>
    </v-data-table-server>
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
  </v-card>
</template>

<script>
import jsPDF from 'jspdf'
import html2canvas from 'html2canvas'
import http from '@/api/api'

export default {
  data() {
    return {
      isDownloading: false,
      isDetail: false,
      pdfUrl: null,
      listUser: [],
      selectedClass: null,
      classrooms: [],
      itemsPerPage: 10,
      headers: [
        { title: 'ID', key: 'id' },
        { title: 'Profile', key: 'profile' },
        { title: 'First Name', key: 'first_name' },
        { title: 'Last Name', key: 'last_name' },
        { title: 'Gender', key: 'gender' },
        { title: 'Age', key: 'age' },
        { title: 'Phone Number', key: 'phone_number' },
        { title: 'Address', key: 'address' },
        { title: 'Email', key: 'email' },
        { title: '', key: 'actions' },
      ]
    }
  },
  // https://stackoverflow.com/questions/63789573/html2canvas-with-jspdf-in-vue-cli-application-dont-work and with AI
  methods: {
    // download pdf ==================================
    downloadPDF() {
      this.isDetail = true
      http
        .get('/get-teachers')
        .then(response => {
          this.teachers = response.data.data
          const element = document.getElementById('my-table')
          html2canvas(element).then(canvas => {
            const imgData = canvas.toDataURL('image/png')
            const pdf = new jsPDF()
            const imgProps = pdf.getImageProperties(imgData)
            const pdfWidth = pdf.internal.pageSize.getWidth()
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width
            pdf.addImage(imgData, 'JPEG', 0, 0, pdfWidth, pdfHeight)
            pdf.save('download.pdf')
            this.isDetail = false
            this.fetchData()
          })
        })
        .catch(error => {
          console.error(error)
        })
    },
    fetchData() {
      http
        .get('/get-teachers')
        .then(response => {
          this.listUser = response.data.data
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
    },
    getTeacher(classId) {
      if (!classId) {
        http
          .get(`/get-teachers`)
          .then(response => {
            this.listUser = response.data.data
          })
          .catch(error => {
            console.log(error)
          })
      } else {
        http
          .get(`/get-teachers`)
          .then(response => {
            this.listUser = response.data.data.filter(
              teacher => parseInt(teacher.class_room_id) === parseInt(classId)
            )
          })
          .catch(error => {
            console.log(error)
          })
      }
    }
  },
  mounted() {
    this.getClassrooms()
    this.getTeacher()
    this.fetchData()
  }
}
</script>

<style scoped>
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,600,700);

/* Bootstrap Icons */
@import url('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css');

/* Set styles for the table */
table {
  border-collapse: collapse;
  width: 100%;
  margin-bottom: 20px;
}

td {
  text-align: left;
  padding: 8px;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #004d40;
  color: white;
}

.table-container {
  margin-left: 18%;
  margin-right: 2px;
}

.icon {
  display: flex;
  justify-content: flex-end;
}
</style>

<template>
  <custom-title icon="mdi-note-check-outline"></custom-title>
  <v-data-table-server
    v-model:items-per-page="itemsPerPage"
    :headers="headers"
    :items="attendanceData"
    :items-length="attendanceData.length"
    :loading="loading"
    :search="search"
    item-value="name"
    class="elevation-1"
  >
    <template v-slot:item.actions="{ item }">
      <v-btn icon="mdi-eye" :to="{ path: '/student/attendance/' + item.id + '/details' }"
        >See Details</v-btn
      >
    </template>
  </v-data-table-server>
</template>
<script>
import http from '@/api/api'
export default {
  data() {
    return {
      attendanceData: [],
      headers: [
        { title: 'Profile', key: 'profile' },
        { title: 'First Name', key: 'first_name' },
        { title: 'Last Name', key: 'last_name' },
        { title: 'Gender', key: 'gender' },
        { title: 'Age', key: 'age', width: '5' },
        { title: 'Email', key: 'email' },
        { title: 'Total', key: 'address' },
        { title: '', key: 'actions', width: '14%' }
      ]
    }
  },
  methods: {
    getStudents(id) {
      http
        .get(`/getAllStudents/${id}`)
        .then(response => {
          this.attendanceData = response.data.data
          this.attendanceData.forEach(element => {
            this.attendanceData = element.students
          })
        })
        .catch(error => {
          console.log(error)
        })
    },
    fetchData() {
      http.get('/getAttendance').then(response => {
        this.attendanceData = response.data
      })
    }
  },
  mounted() {
    const id = this.$route.params.id
    this.getStudents(id)
  }
}
</script>

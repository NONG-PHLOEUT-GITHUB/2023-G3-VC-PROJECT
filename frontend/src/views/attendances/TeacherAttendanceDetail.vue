<template>
  <custom-title icon="mdi-card-account-details"></custom-title>
  <v-data-table
    :headers="headers"
    :items="attendanceRecords"
    :loading="loading"
    :search="search"
    item-value="name"
    class="elevation-0"
  >
  </v-data-table>
</template>
<script>
import axios from 'axios'

export default {
  data() {
    return {
      user: {},
      attendanceRecords: [],
      URL: 'http://127.0.0.1:8000/api/getteacherDetail',
      headers: [
        { title: 'Date', key: 'date' },
        { title: 'Reason', key: 'reason' },
        { title: 'Status', key: 'status' }
      ]
    }
  },
  methods: {
    listattendance(id) {
      axios
        .get(this.URL + '/' + `${id}`)
        .then(response => {
          this.user = response.data.user
          this.attendanceRecords = response.data.attendanceRecords
        })
        .catch(error => {
          console.log(error)
        })
    }
  },
  mounted() {
    const id = this.$route.params.id
    this.listattendance(id)
  }
}
</script>

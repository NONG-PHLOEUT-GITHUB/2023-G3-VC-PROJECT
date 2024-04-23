<template>
  <custom-title icon="mdi-check-decagram-outline"></custom-title>
  <v-data-table-server
    v-model:items-per-page="itemsPerPage"
    v-model="selected"
    :headers="headers"
    :items="attendanceDetails"
    :items-length="attendanceDetails.length || 0"
    :loading="loading"
    :search="search"
    item-value="name"
    class="elevation-2"
  >
  </v-data-table-server>
</template>

<script>
import http from '@/api/api.js'
export default {
  data() {
    return {
      attendanceDetails: [],
      headers: [
        { title: 'Date', key: 'date' },
        { title: 'Reason', key: 'reason' },
        { title: 'Status', key: 'status' }
      ],
    }
  },
  computed: {
    
  },

  methods: {
    getAttendanceDetails() {
      http
        .get('/user')
        .then(response => {
          this.attendanceDetails = response.data.data.attendances
        })
        .catch(error => {
          console.error(error)
        })
    }
  },

  mounted() {
    this.getAttendanceDetails()
  }
}
</script>

<style scoped>
.card {
  margin-left: 17%;
}

.text {
  margin-left: 47%;
  padding: 1%;
}

.container {
  padding: 5px;
}

.table th {
  font-size: 15px;
}

.tab {
  color: white;
  background: #004d40;
}
.thead {
  background: #004d40;
}
.thead th {
  color: white;
}
</style>
.js

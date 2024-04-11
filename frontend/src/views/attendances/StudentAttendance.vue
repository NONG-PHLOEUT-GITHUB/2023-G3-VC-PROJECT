<template>
  <custom-title></custom-title>
  <v-data-table-server></v-data-table-server>
</template>

<script>
import http from '@/api/api.js'
export default {
  data() {
    return {
      tab: 1,
      months: [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
      ],
      attendanceDetails: []
    }
  },
  computed: {
    
  },

  methods: {
    getAttendanceDetails() {
      http
        .get('/v1/auth/user')
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

<template>
  <canvas id="attendanceChart" class="elevation-1"></canvas>
  <canvas id="scoreChart" class="elevation-1 mt-2"></canvas>
</template>
<script>
import http from '@/api/api.js'
import Chart from 'chart.js/auto'

export default {
  name: 'BarChart',
  data() {
    return {
      userId: null,
      chartAttendance: null,
      chartScore: null,
      chartDataAttendance: {
        labels: [
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
        datasets: [
          {
            label: 'Attendance',
            data: []
          }
        ]
      },
      chartDataScore: {
        labels: [
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
        datasets: [
          {
            label: 'Average Score',
            data: []
          }
        ]
      },
      chartOptions: {
        backgroundColor: 'teal',
        responsive: true
      }
    }
  },
  mounted() {
    http
      .get('/v1/auth/user')
      .then(response => {
        this.userId = response.data.data.id
        this.fetchAttendanceData()
        this.fetchScoreData()
      })
      .catch(error => {
        console.error(error)
      })
  },
  methods: {
    fetchAttendanceData() {
      http
        .get(`attendances/student/attendanc/${this.userId}/monthly-attendance`)
        .then(response => {
          const mydata = Object.values(response.data)
          for (let i = 0; i < mydata.length; i++) {
            this.chartDataAttendance.datasets[0].data[i] = mydata[i]
          }
          this.renderAttendanceChart()
        })
        .catch(error => {
          console.error(error)
        })
    },
    fetchScoreData() {
      http
        .get(`scores/student/${this.userId}/monthly-score`)
        .then(response => {
          const mydata = Object.values(response.data.average_scores)
          for (let i = 0; i < mydata.length; i++) {
            this.chartDataScore.datasets[0].data[i] = mydata[i]
          }
          this.renderScoreChart()
        })
        .catch(error => {
          console.error(error)
        })
    },
    renderAttendanceChart() {
      if (this.chartAttendance) {
        this.chartAttendance.destroy()
      }
      const ctx = document.getElementById('attendanceChart').getContext('2d')
      this.chartAttendance = new Chart(ctx, {
        type: 'bar',
        data: this.chartDataAttendance,
        options: this.chartOptions
      })
    },
    renderScoreChart() {
      if (this.chartScore) {
        this.chartScore.destroy()
      }
      const ctx = document.getElementById('scoreChart').getContext('2d')
      this.chartScore = new Chart(ctx, {
        type: 'bar',
        data: this.chartDataScore,
        options: this.chartOptions
      })
    }
  }
}
</script>

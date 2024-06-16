<template>
  <v-card class="mx-auto mb-5" variant="outlined" elevation="1"  color="primary">
    <v-row>
      <v-col>
        <v-card elevation="0" max-height="250">
          <v-avatar size="250">

            <v-img class="align-end text-white" :src="user.profile" cover></v-img>
          </v-avatar>
        </v-card>
      </v-col>
      <v-col cols="6">
        <v-card elevation="0" class="py-8">
          <span>{{ greeting }},</span>
          <v-card-title class="pa-0">
            {{ user.first_name }} {{ user.last_name }}
          </v-card-title>
          <v-card-actions class="pa-0">
            <v-btn
              variant="outlined"
              rounded="xl"
              color="primary"
              text="See profile"
              to="user-profile"
              class="text-none mt-8"
              append-icon="mdi-arrow-right"
            ></v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-card>

  <canvas id="attendanceChart" class="elevation-1"></canvas>
  <!-- <canvas id="scoreChart" class="elevation-1 mt-2"></canvas> -->
</template>
<script>
  import http from '@/api/api.js'
  import Chart from 'chart.js/auto'

  export default {
    name: 'BarChart',
    data() {
      return {
        userId: null,
        user: [],
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
          backgroundColor: '#be4054',
          responsive: true
        }
      }
    },
    computed: {
      greeting() {
        const hour = new Date().getHours()
        if (hour >= 5 && hour < 12) {
          return 'Good morning'
        } else if (hour >= 12 && hour < 18) {
          return 'Good afternoon'
        } else {
          return 'Good evening'
        }
      }
    },
    mounted() {
      http
        .get('/v1/auth/user')
        .then(response => {
          this.userId = response.data.data.id
          this.user = response.data.data
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
          .get(
            `attendances/student/attendanc/${this.userId}/monthly-attendance`
          )
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

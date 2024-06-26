<template>
  <custom-title icon="mdi-view-dashboard-edit"></custom-title>
  <v-row class="mb-4">
    <v-col cols="12" md="4">
      <v-card
        hover
        rounded="xl"
        :subtitle="$t('dashboard.studentTotal')"
        :title="$t('dashboard.student')"
      >
        <v-card-text class="py-0">
          <v-col>
            <h1>
              <strong>{{ results.total }}</strong>
            </h1>
            <h2>
              <v-icon>mdi-gender-male</v-icon>
              {{ results.male }}
              <v-icon>mdi-gender-female</v-icon>
              {{ results.female }}
            </h2>
          </v-col>
        </v-card-text>
        <template v-slot:prepend>
          <v-avatar color="primary">
            <v-icon icon="mdi-account-tie"></v-icon>
          </v-avatar>
        </template>
        <template v-slot:append>
          <v-btn
            border="success sm opacity-100"
            color="green"
            size="small"
            variant="text"
            icon="mdi-arrow-up"
          ></v-btn>
        </template>
      </v-card>
    </v-col>
    <v-col cols="12" md="4">
      <v-card
        rounded="xl"
        hover
        :subtitle="$t('dashboard.teacherTotal')"
        :title="$t('dashboard.teacher')"
      >
        <template v-slot:prepend>
          <v-avatar color="primary">
            <v-icon icon="mdi-human-male-board-poll"></v-icon>
          </v-avatar>
        </template>
        <template v-slot:append>
          <v-btn
            border="success sm opacity-100"
            color="green"
            size="small"
            variant="text"
            icon="mdi-arrow-up"
          ></v-btn>
        </template>
        <v-card-text class="py-0">
          <v-col>
            <h1>
              <strong>{{ student.total }}</strong>
            </h1>
            <h2>
              <v-icon>mdi-gender-male</v-icon>
              {{ student.male }}
              <v-icon>mdi-gender-female</v-icon>
              {{ student.female }}
            </h2>
          </v-col>
        </v-card-text>
      </v-card>
    </v-col>
    <v-col cols="12" md="4">
      <!-- border="opacity-50 sm"
      class="mx-auto elevation-0" -->
      <v-card
        rounded="xl"
        :subtitle="$t('dashboard.classTotal')"
        :title="$t('dashboard.class')"
        hover
      >
        <template v-slot:prepend>
          <v-avatar color="primary">
            <v-icon icon="mdi-google-classroom"></v-icon>
          </v-avatar>
        </template>
        <template v-slot:append>
          <v-btn
            border="success sm opacity-100"
            color="green"
            size="small"
            variant="text"
            icon="mdi-arrow-up"
          ></v-btn>
        </template>
        <v-card-text class="py-0">
          <v-col>
            <h1>
              <strong>{{ classroom }}</strong>
            </h1>
            <h2>
              <v-icon>mdi-chair-rolling</v-icon>
              4000
            </h2>
          </v-col>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>

  <custom-sub-title icon="mdi-chart-bar">
    {{ $t('dashboard.subtitle') }}
  </custom-sub-title>
  <v-row class="mt-2 px-2 d-flex justify-space-between">
    <v-card width="48%" class="elevation-0">
      <canvas id="attendanceChart" height="170"></canvas>
    </v-card>
    <v-card width="48%" class="elevation-0">
      <canvas id="FailedChart" height="170"></canvas>
    </v-card>
  </v-row>
</template>

<script>
  import Chart from 'chart.js/auto'
  import http from '@/api/api'

  export default {
    name: 'BarChart',
    data() {
      return {
        results: '',
        student: '',
        classroom: '',
        chartAttendance: null,
        studentFailed: null,
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
              label: 'Attendance average',
              data: []
            }
          ]
        },
        chartDataStudentFailed: {
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
              label: 'Percentage of failed students',
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

    created() {
      this.fetchTotalData()
      this.fetchFailedStudentData()
      this.fetchTotalOfClass()
      this.showGraphOfStudentAttendance()
    },

    methods: {
      async fetchTotalData() {
        try {
          const response = await http.get('users/get/total')
          this.student = response.data.data[1]
          this.results = response.data.data[2]
        } catch (error) {
          console.log(error)
        }
      },
      async fetchTotalOfClass() {
        try {
          const response = await http.get('classrooms/total/classroom-total')
          this.classroom = response.data.data
        } catch (error) {
          console.log(error)
        }
      },

      async fetchFailedStudentData() {
        try {
          const response = await http.get('users/graph-student/fail')
          const mydata = response.data.failed_users_percentage
          for (let i = 0; i < mydata.length; i++) {
            this.chartDataStudentFailed.datasets[0].data[i] = mydata[i]
          }
          this.renderFailedChart()
        } catch (error) {
          console.log(error)
        }
      },

      async showGraphOfStudentAttendance() {
        try {
          const response = await http.get(
            'attendances/show-grahp-of-student-attendance'
          )
          const mydata = Object.values(response.data)
          for (let i = 0; i < mydata.length; i++) {
            this.chartDataAttendance.datasets[0].data[i] = mydata[i]
          }
          this.renderAttendanceChart()
        } catch (error) {
          console.error(error)
        }
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
      renderFailedChart() {
        if (this.studentFailed) {
          this.studentFailed.destroy()
        }
        const ctx = document.getElementById('FailedChart').getContext('2d')
        this.studentFailed = new Chart(ctx, {
          type: 'bar',
          data: this.chartDataStudentFailed,
          options: this.chartOptions
        })
      }
    }
  }
</script>

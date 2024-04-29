<template>
  <custom-title icon="mdi-view-dashboard-edit"></custom-title>
  <v-row class="mb-4">
    <v-col cols="12" md="4">
      <v-card class="mx-auto" subtitle="All students in school" title="Students">
        <template v-slot:prepend>
          <v-avatar color="blue-darken-2">
            <v-icon icon="mdi-account-tie"></v-icon>
          </v-avatar>
        </template>
        <v-col>
          <h3>
            <strong>{{results.total}}</strong>
          </h3>
          <h5>
            <v-icon>mdi-gender-male</v-icon>{{results.male}} 
            <v-icon>mdi-gender-female</v-icon>{{results.female}}
          </h5>
        </v-col>
      </v-card>
    </v-col>
    <v-col cols="12" md="4">
      <v-card class="mx-auto" subtitle="All teachers in school" title="Teachers">
        <template v-slot:prepend>
          <v-avatar color="blue-darken-2">
            <v-icon icon="mdi-human-male-board-poll"></v-icon>
          </v-avatar>
        </template>
        <v-col>
          <h3>
            <strong>{{student.total}}</strong>
          </h3>
          <h5><v-icon>mdi-gender-male</v-icon>{{student.male}} <v-icon>mdi-gender-female</v-icon>{{student.female}}</h5>
        </v-col>
      </v-card>
    </v-col>
    <v-col cols="12" md="4">
      <v-card class="mx-auto" subtitle="All classrooms in school" title="Crassroom">
        <template v-slot:prepend>
          <v-avatar color="blue-darken-2">
            <v-icon icon="mdi-google-classroom"></v-icon>
          </v-avatar>
        </template>
        <v-col>
          <h3>
            <strong>{{ classroom }}</strong>
          </h3>
          <h5>
            <v-icon>mdi-chair-rolling</v-icon>40
          </h5>
        </v-col>
      </v-card>
    </v-col>
  </v-row>

  <custom-sub-title icon="mdi-chart-bar">Graph of student attendance and student failed</custom-sub-title>
  <v-row class="mt-2 px-2">
    <v-col cols="6"  class="elevation-1">
      <Bar id="my-chart-id" :options="chartOptions" :data="chartData" />
    </v-col>
    <v-col cols="6"  class="elevation-1">
      <Bar id="my-chart-id" :options="chartOptions" :data="chartData1" />
    </v-col>
  </v-row>

  <!-- <StudentMostAbsence /> -->
</template>

<script>
import { Bar } from 'vue-chartjs'
import http from '@/api/api'
// import StudentMostAbsence from '@/components/dashboard/StudentMostAbsence.vue'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
  name: 'BarChart',
  components: {
    // StudentMostAbsence,
    Bar
  },
  data() {
    return {
      results: '',
      student:'',
      classroom: '',
      attendance: '',
      chartData: {
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
      chartData1: {
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
            label: 'Percentage of failed students(%)',
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
          this.chartData1.datasets[0].data[i] = mydata[i]
        }
      } catch (error) {
        console.log(error)
      }
    },

    async showGraphOfStudentAttendance() {
      try {
        const response = await http.get('attendances/show-grahp-of-student-attendance')
        const mydata = Object.values(response.data)
        for (let i = 0; i < mydata.length; i++) {
          this.chartData.datasets[0].data[i] = mydata[i]
        }
      } catch (error) {
        console.error(error)
      }
    }
  }
}
</script>

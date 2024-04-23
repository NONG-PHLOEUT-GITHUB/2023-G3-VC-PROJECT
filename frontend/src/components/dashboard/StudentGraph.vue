<template>
  <v-row>
    <v-col cols="6" >
      <Bar class="elevation-1" :options="chartOptions" :data="chartData" />
      <Bar class="elevation-1 mt-2" :options="chartOptions" :data="chartData1" />
    </v-col>
    <!-- <v-col cols="3" class="elevation-1">
    </v-col> -->
  </v-row>
</template>
<script>
import http from '@/api/api.js'
import { Bar } from 'vue-chartjs'
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
  components: { Bar },
  data() {
    return {
      userId: null,
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
            label: 'Attendance',
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
      .get('/user')
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
        .get(`/getstudentattendanceeverymonth/${this.userId}`)
        .then(response => {
          const mydata = Object.values(response.data)
          for (let i = 0; i < mydata.length; i++) {
            this.chartData.datasets[0].data[i] = mydata[i]
          }
        })
        .catch(error => {
          console.error(error)
        })
    },
    fetchScoreData() {
      http
        .get(`/getStudentScoreEveryMonth/${this.userId}`)
        .then(response => {
          const mydata = Object.values(response.data.average_scores)
          for (let i = 0; i < mydata.length; i++) {
            this.chartData1.datasets[0].data[i] = mydata[i]
          }
        })
        .catch(error => {
          console.error(error)
        })
    }
  }
}
</script>


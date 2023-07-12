<template>
  <main class="py-6 bg-surface-secondary">
    <div class="container-fluid">
      <div class="row g-6 mb-6">
        <div class="col-xl-3 col-sm-6 col-12">
          <div class="card shadow border-0">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <span class="h6 font-semibold text-muted text-sm d-block mb-2"
                    >Students</span
                  >
                  <span
                    v-for="(result, index) in results"
                    :key="index"
                    class="h3 font-bold mb-0"
                  >
                    <p
                      class="h6 font-semibold text-muted text-sm d-block mb-2"
                      v-if="result.role == 3"
                    >
                      Total : {{ result.total }}, Male: {{ result.male }},
                      Female: {{ result.female }}
                    </p>
                  </span>
                </div>
                <div class="col-auto">
                  <div
                    class="icon icon-shape bg-tertiary text-white text-lg rounded-circle"
                  >
                    <i class="bi bi-people"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
          <div class="card shadow border-0">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <span class="h6 font-semibold text-muted text-sm d-block mb-2"
                    >Teachers</span
                  >
                  <span
                    v-for="(result, index) in results"
                    :key="index"
                    class="h3 font-bold mb-0"
                  >
                    <p
                      class="h6 font-semibold text-muted text-sm d-block mb-2"
                      v-if="result.role == 2"
                    >
                      Total : {{ result.total }}, Male: {{ result.male }},
                      Female: {{ result.female }}
                    </p>
                  </span>
                </div>
                <div class="col-auto">
                  <div
                    class="icon icon-shape bg-primary text-white text-lg rounded-circle"
                  >
                    <i class="bi bi-people"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
          <div class="card shadow border-0">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <span class="h6 font-semibold text-muted text-sm d-block mb-2"
                    >Class</span
                  >
                  <span class="h3 font-bold mb-0">40</span>
                </div>
                <div class="col-auto">
                  <div
                    class="icon icon-shape bg-info text-white text-lg rounded-circle"
                  >
                    <i class="bi bi-building"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
          <div class="card shadow border-0">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <span class="h6 font-semibold text-muted text-sm d-block mb-2"
                    >Libary</span
                  >
                  <span class="h3 font-bold mb-0">2</span>
                </div>
                <div class="col-auto">
                  <div
                    class="icon icon-shape bg-warning text-white text-lg rounded-circle"
                  >
                    <i class="bi bi-book"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <h3>REPORTS</h3>
    <div class="row">

      <div class="col-sm-6">
        <div class="card shadow-lg mt-5 p-3">
          <div class="chart">
            <Bar
            id="my-chart-id"
            :options="chartOptions"
            :data="chartData"
            />
            <h5 class="text-center m-3 text-warning">STUDENT ATTENDANCE</h5>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card shadow-lg mt-5 p-3">
          <div class="chart">
            <Bar
            id="my-chart-id"
            :options="chartOptions"
            :data="chartData1"
            />
            <h5 class="text-center m-3 text-warning">FAILED STUDENT</h5>
          </div>
        </div>
      </div>

    </div>

  </main>
</template>

<script>
// import axios from "axios";
import { Bar } from "vue-chartjs";
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from "chart.js";

// export default {
//   data() {
//     return {
//       results:''
//     };
//   },
//   mounted() {
//     axios.get('http://127.0.0.1:8000/api/getTotal')
//       .then(response => {
//        this.results = response.data.data
//       })
//       .catch(error => {
//         console.log(error);
//       });
//   }
// }

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
);

export default {
  name: "BarChart",
  components: { Bar },
  data() {
    return {
      URL: "http://127.0.0.1:8000/api",
      results: "",
      attendance: "",
      chartData: {
        labels: [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [ { 
          label: "Attendance average", 
          data: [40, 20, 12, 45, 32, 22, 11, 33, 44, 59, 55, 43] } ],
    },
      chartData1: {
        labels: [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [ { 
          label: "Average of failed students",
          data: [40, 20, 12, 45, 32, 22, 11, 33, 44, 59, 55, 43] } ],
    },
    chartOptions: {
        backgroundColor: '#1E90FF',
        responsive: true
      }
    }
  },
  // mounted() {
  //   axios.get(this.URL + "/getAverageAbsentAttendanceByMonth")
  //     .then(response => {
  //       this.attendance = response.data.averageAbsentAttendanceByMonth;
  //       this.chartData.datasets[0].data = Object.values(this.attendance);
  //     })
  //     .catch(error => {
  //       console.log(error);
  //     });
  // }
}
</script>
<style>
@import url(https://unpkg.com/@webpixels/css@1.1.5/dist/index.css);

/* Bootstrap Icons */
@import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");
</style>

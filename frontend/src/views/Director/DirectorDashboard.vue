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
                    >Studnets</span
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
    <div class="charts d-flex" style="width: 100%;">
      <div class="chart" style="width: 50%;">
        <Bar
        id="my-chart-id"
        :options="chartOptions"
        :data="chartData"
        />
        <h5 class="text-center">STUDENT ATTENDANCE</h5>
      </div>
      <div class="chart" style="width: 50%;">
        <Bar
        id="my-chart-id"
        :options="chartOptions"
        :data="chartData1"
        />
        <h5 class="text-center">FAILED STUDENT</h5>
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
      results: "",
      chartData: {
        labels: [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [ { 
          label: "Attendance average", 
          data: [40, 20, 12, 45, 32, 22, 11, 33, 44, 58, 55, 43] } ],
    },
      chartData1: {
        labels: [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [ { 
          label: "Average of failed students",
          data: [10, 20, 12, 45, 32, 22, 11, 33, 44, 69, 55, 43] } ],
    },
    chartOptions: {
        backgroundColor: '#FFA500',
        responsive: true
      }
    }
  }
}
</script>
<style>
@import url(https://unpkg.com/@webpixels/css@1.1.5/dist/index.css);

/* Bootstrap Icons */
@import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");
</style>

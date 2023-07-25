<template>
  <admin-dashboard></admin-dashboard>
  <div class="card-container">
  <v-row class="mt-7 ms-24">
    <v-card width="390" class="me-2" prepend-icon="mdi-account-tie">
      <template v-slot:title>Teachers </template>

      <v-card-text class="card-text" v-for="(result, index) in results" :key="index"> 
        <h5 v-if="result.role == 3">
          Total : {{ result.total }}
          <v-spacer></v-spacer>
           Male: {{ result.male }}
          <v-spacer></v-spacer>
           Female: {{ result.female }}
        </h5>
       </v-card-text>
    </v-card>
    <v-card   width="390" prepend-icon="mdi-account">
      <template v-slot:title> Students </template>
      <v-card-text class="card-text" v-for="(result, index) in results" :key="index">
      <h5 v-if="result.role == 2">
          Total : {{ result.total }}
          <v-spacer></v-spacer>
          Male: {{ result.male }}
          <v-spacer></v-spacer>
          Female: {{ result.female }}
      </h5>
      </v-card-text>
    </v-card>
    <v-card  width="400" class="ms-2" prepend-icon="mdi-school">
      <template v-slot:title> Class </template>

      <v-card-text class="ms-14"> 
        <h5>Total 10 class</h5>
       </v-card-text>
    </v-card>
  </v-row>
</div>
  <main class="main mt-6">
    <h3>REPORTS</h3>
  <v-row class="mt-8">
    <v-card class="bar1">
      <Bar id="my-chart-id" :options="chartOptions" :data="chartData" />
      <h5 class="text-center m-3 text-warning">STUDENT ATTENDANCE</h5>
    </v-card>
    <v-card class="bar2 ms-4">
      <Bar id="my-chart-id" :options="chartOptions" :data="chartData1" />
      <h5 class="text-center m-3 text-warning">FAILED STUDENT</h5>
    </v-card>
  </v-row>
  </main>
</template>

<script>
import axios from "axios";
import { Bar } from "vue-chartjs";
import http from "../../htpp.common";
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from "chart.js";

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
      chartData: {
        labels: [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
          "August",
          "September",
          "October",
          "November",
          "December",
        ],
        datasets: [
          {
            label: "Attendance average",
            data: [40, 20, 12, 45, 32, 22, 11, 33, 44, 59, 55, 43],
          },
        ],
      },
      chartData1: {
        labels: [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
          "August",
          "September",
          "October",
          "November",
          "December",
        ],
        datasets: [
          {
            label: "Percentage of failed students(%)",
            data: [],
          },
        ],
      },
      chartOptions: {
        backgroundColor: "#1E90FF",
        responsive: true,
      },
    };
  },
  mounted() {
    http
      .get("/api/getTotal")
      .then((response) => {
        this.results = response.data.data;
      })
      .catch((error) => {
        console.log(error);
      });
    axios
      .get(this.URL + "/getPercentageOfFaildedStudentByMonth")
      .then((response) => {
        const mydata = response.data.failed_users_percentage;
        console.log(mydata);
        for (let i = 0; i < mydata.length; i++) {
          this.chartData1.datasets[0].data[i] = mydata[i];
        }
        console.log(this.chartData1.datasets[0].data);
      })
      .catch((error) => {
        console.log(error);
      });
  },

};
</script>
<style>

@import url(https://unpkg.com/@webpixels/css@1.1.5/dist/index.css);

/* Bootstrap Icons */
@import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");

.main {
  margin-left: 19%;
  margin-right: 10px;
}

.card-container{
  padding: 10px;
  margin-left: 11%;
}
.card-text{
  margin-top: -25px;
  margin-left: 60px;
}

.bar1{
  width: 48%;
}
.bar2{
  width: 49%;
}

</style>

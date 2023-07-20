<template>
  <h3 class="col-sm-9 m-auto ">REPORTS SCORE</h3>
  <div class="row">
    <div class="col-sm-9 m-auto ">
      <div class="card shadow-lg mt-5 p-5">
        <div class="chart">
          <Bar id="my-chart-id" :options="chartOptions" :data="chartData" />
          <h5 class="text-center m-30 text-warning">STUDENT SCORE</h5>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
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
      attendance: "",
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
            label: "Score average",
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
            label: "Average of failed students",
            data: [40, 20, 12, 45, 32, 22, 11, 33, 44, 59, 55, 43],
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
    axios
      .get("http://127.0.0.1:8000/api/getTotal")
      .then((response) => {
        this.results = response.data.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>

<style>
</style>
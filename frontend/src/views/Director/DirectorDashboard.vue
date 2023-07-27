<template>
  <admin-dashboard></admin-dashboard>
  <div class="card-container">
    <v-row class="mt-7 ms-24">
      <v-card width="390" class="me-2" prepend-icon="mdi-account-tie">
        <template v-slot:title>Teachers </template>

        <v-card-text
          class="card-text"
          v-for="(result, index) in results"
          :key="index"
        >
          <h5 v-if="result.role == 3">
            Total : {{ result.total }}
            <v-spacer></v-spacer>
            Male: {{ result.male }}
            <v-spacer></v-spacer>
            Female: {{ result.female }}
          </h5>
        </v-card-text>
      </v-card>
      <v-card width="390" prepend-icon="mdi-account">
        <template v-slot:title> Students </template>
        <v-card-text
          class="card-text"
          v-for="(result, index) in results"
          :key="index"
        >
          <h5 v-if="result.role == 2">
            Total : {{ result.total }}
            <v-spacer></v-spacer>
            Male: {{ result.male }}
            <v-spacer></v-spacer>
            Female: {{ result.female }}
          </h5>
        </v-card-text>
      </v-card>
      <v-card width="400" class="ms-2" prepend-icon="mdi-school">
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
  <main class="main mt-6">
    <v-row class="mt-8">
      <v-card class="bar1">
        <main class="table">
          <h4 class="m-3 text-warning">STUDENT MOST ABSENCE LIST</h4>
          <table>
            <thead>
              <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Total Absence</th>
                <th>See More</th>
              </tr>
            </thead>
            <tbody
              v-for="attendanceItem in attendanceStudentData"
              :key="attendanceItem.id"
            >
              <tr v-if="attendanceItem.role_attendances_count >= 1">
                <td>{{ attendanceItem.first_name }}</td>
                <td>{{ attendanceItem.last_name }}</td>
                <td>{{ attendanceItem.role_attendances_count }}</td>
                <td>
                  <router-link
                    class="status detail"
                    :to="{
                      path: '/studentattendancedetail/' + attendanceItem.id,
                    }"
                    >Detail</router-link
                  >
                </td>
              </tr>
            </tbody>
          </table>
        </main>
      </v-card>
      <v-card class="bar2 ms-4">
        <main class="table">
          <h4 class="m-3 text-warning">TEACHER MOST ABSENCE LIST</h4>
          <table>
            <thead>
              <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Total Absence</th>
                <th>See More</th>
              </tr>
            </thead>
            <tbody
              v-for="attendanceItem in attendanceTeacherData"
              :key="attendanceItem.id"
            >
              <tr v-if="attendanceItem.role_attendances_count >= 1">
                <td>{{ attendanceItem.first_name }}</td>
                <td>{{ attendanceItem.last_name }}</td>
                <td>{{ attendanceItem.role_attendances_count }}</td>
                <td>
                  <router-link
                    class="status detail"
                    :to="{
                      path: '/teacherattendancedetail/' + attendanceItem.id,
                    }"
                    >Detail</router-link
                  >
                </td>
              </tr>
            </tbody>
          </table>
        </main>
      </v-card>
    </v-row>
  </main>
</template>

<script>
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
import axios from "axios";
export default {
  name: "BarChart",
  components: { Bar },
  data() {
    return {
      results: "",
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
            label: "Attendance average",
            data: [],
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
      .get("/getTotal")
      .then((response) => {
        this.results = response.data.data;
      })
      .catch((error) => {
        console.log(error);
      });

      http
      .get("/getPercentageOfFaildedStudentByMonth")
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
  methods: {
    fetchAttendanceData() {
      http
        .get("/totalattendanceofstudent/9")
        .then((response) => {
          const mydata = Object.values(response.data);
          for (let i = 0; i < mydata.length; i++) {
            this.chartData.datasets[0].data[i] = mydata[i];
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    fetchFaildedStudentData() {
      http
        .get("/getPercentageOfFaildedStudentByMonth")
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
    fetchMostAbsenceStudentData() {
      axios
        .get(this.URL + "/getMostAbsence")
        .then((response) => {
          this.attendanceStudentData = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    fetchMostAbsenceTeacherData() {
      axios
        .get(this.URL + "/getTeacherMostAbsence")
        .then((response) => {
          this.attendanceTeacherData = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  // mounted() {
  //   axios.get(this.URL + "/getAbsentPercentageByMonth")
  //     .then(response => {
  //       this.attendance = response.data.absentPercentage;
  //       this.chartData.datasets[0].data = Object.values(this.attendance);
  //     })
  //     .catch(error => {
  //       console.log(error);
  //     });
  // }
};
</script>
<style scoped>
@import url(https://unpkg.com/@webpixels/css@1.1.5/dist/index.css);

/* Bootstrap Icons */
@import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");

.main {
  margin-left: 19%;
  margin-right: 10px;
}

.card-container {
  padding: 10px;
  margin-left: 11%;
}
.card-text {
  margin-top: -25px;
  margin-left: 60px;
}

.bar1 {
  width: 48%;
}
.bar2 {
  width: 49%;
}
main.table {
  margin: auto;
  border-radius: 10px;
  padding: 2%;
}
h3 {
  margin-bottom: 20px;
  text-transform: uppercase;
  color: #0000ff;
}
table {
  padding: 2%;
  width: 100%;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
}
table,
th,
td {
  border-collapse: collapse;
  padding: 1rem;
  text-align: left;
}
td {
  font-weight: bold;
  font-size: 15px;
}
thead th {
  position: sticky;
  top: 0;
  left: 0;
  background-color: #0000ff;
  cursor: pointer;
  text-transform: uppercase;
  color: white;
  font-size: 16px;
  font-weight: bold;
}
.status.detail {
  padding: 10px 25px;
  margin-left: 10px;
  border-radius: 3px;
  background-color: #0000ff;
  color: white;
  font-weight: bold;
}
</style>
   
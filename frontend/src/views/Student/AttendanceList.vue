<template>
  <admin-dashboard></admin-dashboard>
  <main class="table">
    <h3>Student Attendance List</h3>
    <v-table>
      <thead>
        <tr>
          <th class="text-white">Id</th>
          <th class="text-white">First Name</th>
          <th class="text-white">Last Names</th>
          <th class="text-white">Total Absence</th>
          <th class="text-white">See More</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(attendanceItem, index) in attendanceData" :key="index">
          <td>{{ index + 1 }}</td>
          <td>{{ attendanceItem.first_name }}</td>
          <td>{{ attendanceItem.last_name }}</td>
          <td>{{ attendanceItem.role_attendances_count }}</td>
          <td>
            <router-link
              class="status detail bg-warning"
              :to="{ path: '/studentattendancedetail/' + attendanceItem.id }"
              >See Details</router-link
            >
          </td>
        </tr>
      </tbody>
    </v-table>
  </main>
</template>
<script>
import http from "@/htpp.common";

export default {
  data() {
    return {
      attendanceData: [],
    };
  },
  methods: {
    getStudents(id) {
      http
        .get(`/getAllStudents/${id}`)
        .then((response) => {
          this.attendanceData = response.data.data;
          this.attendanceData = response.data.data;
          this.attendanceData.forEach((element) => {
            console.log(element.students);
            this.attendanceData = element.students;
          });
          console.log(this.attendanceData);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    fetchData() {
      http.get("/getAttendance").then((response) => {
        this.attendanceData = response.data;
        console.log(response.data);
      });
    },
  },
  mounted() {
    const id = this.$route.params.id;
    this.getStudents(id);
    this.fetchData();
  },
};
</script>

<style scoped>
* thead th {
  position: sticky;
  top: 0;
  left: 0;
  background-color: #0000ff;
  cursor: pointer;
  text-transform: uppercase;
  color: white;
  font-size: 15px;
  font-weight: bold;
}

tbody tr:hover {
  background-color: #fff6 !important;
}
.status.detail {
  padding: 10px;
  margin-left: 10px;
  border-radius: 10px;
  background-color: #0000ff;
  color: white;
  font-weight: bold;
}
thead th:hover {
  color: #e8e8fa;
}
main {
  width: 80%;
  margin-left: 20%;
  margin-top: 20px;
}
</style>

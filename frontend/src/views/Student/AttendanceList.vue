<template>
  <admin-dashboard></admin-dashboard>
  <main class="table">
    <h3>Student Attendance List</h3>
    <v-table>
      <thead>
        <tr>
          <th class="text-left">Id</th>
          <th class="text-left">First Name</th>
          <th class="text-left">Last Names</th>
          <th class="text-left">Total Absence</th>
          <th class="text-left">See More</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="attendanceItem in attendanceData" :key="attendanceItem.id">
          <td>{{ attendanceItem.id }}</td>
          <td>{{ attendanceItem.first_name }}</td>
          <td>{{ attendanceItem.last_name }}</td>
          <td>{{ attendanceItem.role_attendances_count }}</td>
          <td>
            <router-link class="status detail" :to="{ path: '/studentattendancedetail/'+ attendanceItem.id }">Detail</router-link>
          </td>
        </tr>
      </tbody>
    </v-table>
  </main>
</template>
<script>
import axios from "axios";

export default {
  data() {
    return {
      attendanceData: [],
      URL: "http://127.0.0.1:8000/api/getAttendance",
    };
  },
  mounted() {
    axios
      .get(this.URL)
      .then((response) => {
        this.attendanceData = response.data;
        console.log(this.attendanceData);
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>

<style scoped>
*

thead th {
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
main{
  width: 80%;
  margin-left: 20%;
  margin-top: 20px;
}
</style>
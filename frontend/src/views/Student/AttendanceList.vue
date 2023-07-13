<template>
  <main class="table">
    <h3>Student Attendance List</h3>
    <table>
      <thead>
        <tr>
          <th>Id</th>
          <th>First_Name</th>
          <th>Last_Name</th>
          <th>Total_Absence</th>
          <th>See More</th>
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
    </table>
  </main>
</template>
<script>
import axios from "axios";

export default {
  data() {
    return {
      attendanceData: [],
    };
  },
  mounted() {
    axios
      .get("http://127.0.0.1:8000/api/getAttendance")
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
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: sans-serif;
}
body {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}
main.table {
  margin: auto;
  width: 65vw;
  background-color: #fff5;
  border-radius: 10px;
  padding: 2%;
}
h3 {
  padding: 2%;
  text-transform: uppercase;
  color: #5cd2c6;
}
table {
  padding: 2%;
  width: 100%;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
}

td img {
  width: 36px;
  height: 36px;
  margin-right: 0.5rem;
  border-radius: 50%;

  vertical-align: middle;
}

table,
th,
td {
  border-collapse: collapse;
  padding: 1rem;
  text-align: left;
}

thead th {
  position: sticky;
  top: 0;
  left: 0;
  background-color: #d5d1defe;
  cursor: pointer;
  text-transform: capitalize;
}
tbody tr:nth-child(even) {
  background-color: #0000000b;
}
tbody tr:hover {
  background-color: #fff6 !important;
}
.status.detail {
  padding: 0.4rem 1.5rem;
  border-radius: 2rem;
  text-align: center;
  background-color: #50ded9;
  color: #006b21;
}
thead th:hover {
  color: #5cd2c6;
}
</style>
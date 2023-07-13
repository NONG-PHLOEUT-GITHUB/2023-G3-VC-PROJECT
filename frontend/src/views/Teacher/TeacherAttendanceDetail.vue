<template>
  <main class="table">
    <h4>
      Attendance Records for
      <span> {{ user.first_name }} {{ user.last_name }}</span>
    </h4>
    <table>
      <thead>
        <tr>
          <th>date</th>
          <th>reason</th>
          <th>attendance_status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="record in attendanceRecords" :key="record.id">
          <td>{{ record.date }}</td>
          <td>{{ record.reason }}</td>
          <td>{{ record.attendace_status }}</td>
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
      user: {},
      attendanceRecords: [],
    };
  },
  methods: {
    listattendance(id) {
      axios
        .get(`http://127.0.0.1:8000/api/getteacherDetail/${id}`)
        .then((response) => {
          this.user = response.data.user;
          this.attendanceRecords = response.data.attendanceRecords;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    const id = this.$route.params.id;
    this.listattendance(id);
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
h4 {
  padding: 2%;
  text-transform: uppercase;
  color: #5cd2c6;
}
span {
  padding: 2%;
  text-transform: uppercase;
  color: #1b1e1d;
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
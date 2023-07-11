<template>
  <div class="container">
      <h1>Attendance Check List</h1>
      <div>
        <p>This is Attendance of Today</p>
      </div>
      <div>
          <input type="checkbox" class="selectattendance" @click="SelectAttendace()">Attendance Today 
      </div>

      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Gender</th>
            <th>Status</th>
            <th>Reason</th>
          </tr>
        </thead>
        <tbody >
          <tr v-for="student in students" :key="student.id">
            <td>{{ student.name }}</td>
            <td>{{ student.gender }}</td>
            <td>
              <input type="checkbox" v-model="attendance_status"> Present
            </td>
            <td>{{ student.reason }}</td>
          </tr>
        </tbody>
        
      </table>
      <button class="save" @click="saveListAttendence()">Save</button>
    </div>
</template>

<script>
import swal from "sweetalert2";
import axios from "axios";
export default {
   name: "SweetAlert2",
  data() {
    return {
      students: [
        { id: 1, name: "John", gender: "Male", reason: "Sick", status: false },
      ],
      date: null,
      attendance_status: "",
      URL: "http://127.0.0.1:8000/api/attendance",
    };
  },
  // copy by "https://stackoverflow.com/questions/57249466/getting-current-time-and-date-in-vue-js"
  methods: {
    SelectAttendace() {
      const today = new Date();
      const date =
        today.getFullYear() +
        "-" +
        (today.getMonth() + 1) +
        "-" +
        today.getDate();
      this.date = date;
      console.log(this.date);
      this.students.forEach((student) => {
        student.status = false;
      });
    },
    saveListAttendence() {
      const newAttend = {
        attendance_status: this.attendance_status,
        date: this.date,
      };
      axios.post(this.URL, newAttend).then((response) => {
        swal.fire({
          icon: "success",
          title: "Save attendance successfully!",
          text: "you already save your attendance",
          timer: 2000,
        });
        console.log(response);
      });
    },

    created() {
      setInterval(this.getNow, 1000);
    },
    mounted() {
      this.getStudentData();
      this.saveListAttendence();
    },
  },
}
</script>

<style  scoped>
table {
  padding: 2%;
  width: 100%;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
}

table {
  border-collapse: collapse;
  width: 90%;
  margin-top: 20px;
  margin-bottom: 20px;
  margin-left: 5%;
}

th,
td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: center;
}

th {
  background-color: #cec9c9;
  text-align: center;
}

td:first-child {
  font-weight: bold;
}
td.status {
  position: relative;
  padding-left: 30px;
}

h1,
p {
  margin-left: 5%;
}
.save {
  padding: 10px;
  background: lightblue;
  border: 1px solid lightblue;
  width: 10%;
  margin-top: 10px;
  margin-left: 85%;
}
.selectattendance {
  padding: 10px;
  background: lightblue;
  border: 1px solid lightblue;
  margin-left: 65px;
}

</style>
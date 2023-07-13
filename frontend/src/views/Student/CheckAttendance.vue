<template>
  <div class="container">
      <h2>Attendance Check List</h2><br>
      <div class="checkToday">
          <input type="checkbox" class="selectattendance" @click="SelectAttendace()">Attendance Today 
          {{ this.date }}
      </div>

      <table>
        <thead>
          <tr>
            <th>FirstName</th>
            <th>LastName</th>
            <th>Gender</th>
            <th>Status</th>
            <th>Reason</th>
          </tr>
        </thead>
        <tbody >
          <tr v-for="student in students" :key="student.id">
            <td>{{ student.first_name }}</td>
            <td>{{ student.last_name }}</td>
            <td>{{ student.gender }}</td>
            <td>
              <!-- <input type="checkbox" v-model="attendance_status"> Present -->
                <div class="dropdown rounded-1" >
                  <select v-model="attendance_status" class="btn dropdown-toggle  " placeholder="" >
                    <option value="Present">
                      <p>Present</p>
                    </option>
                    <option value="Absent">
                      <p>Absent</p>
                    </option>
                    <option value="Early">
                      <p>Early</p>
                    </option>
                    <option value="Late">
                      <p>Late</p>
                    </option>
                    <option value="Excused">
                      <p>Excused</p>
                    </option>
                    <option value="Unexcused">
                      <p>Unexcused</p>
                    </option>
                    <option value="On leave">
                      <p>On leave</p>
                    </option>
                    <option value="No show">
                      <p>No show</p>
                    </option>
                  </select>
                </div>             
            </td>
            <td>
              <textarea type="tel" v-model="reason" class="form-control" id="reason" placeholder="" />
            </td>
          </tr>
        </tbody>
        
      </table>
      <div class="col-12 d-flex justify-content-end btn">
          <button type="submit" class="btn btn-primary text-white" @click="saveListAttendence()" >Save</button>
      </div>
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
        { id: 1, first_name: "Cheiipok",last_name:"Doem", gender: "Male", reason: "Sick", status: false },
      ],
      date: null,
      attendance_status: "",
      reason: "",
      URL: "http://127.0.0.1:8000/api/checkStudentAttendance",
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
      if(this.attendance_status != '' && this.date != '' && this.reason != '') {
        const newAttend = {
          attendance_status: this.attendance_status,
          date: this.date,
          reason: this.reason
        };
        console.log(newAttend);
        axios.post(this.URL, newAttend).then((response) => {
          swal.fire({
            icon: "success",
            title: "Save attendance successfully!",
            text: "you already save your attendance",
            timer: 2000,
          });
          console.log(response);
        });
      }else{
        swal.fire(
        'Complete first',
        'complete all input',
        'info'
      )  
      }
    },

    created() {
      setInterval(this.getNow, 1000);
    },
    mounted() {
      this.getStudentData();
      // this.saveListAttendence();
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
  width: 95%;
  margin-top: 20px;
  margin-bottom: 20px;
  margin-left: 3%;
}

th,
td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: center;
}

th {
  background-color: #306ddf;
  text-align: center;
  color: white;
}


td.status {
  position: relative;
  padding-left: 30px;
}
.btn{
  margin-right: 0.5%;
}


.selectattendance {
  padding: 10px;
  margin-left: 34px;
}

</style>
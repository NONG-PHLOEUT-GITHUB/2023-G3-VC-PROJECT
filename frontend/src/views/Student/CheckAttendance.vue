<template>
  <teacher-dashboard></teacher-dashboard>
  <div class="container mt-5">
    <v-card>
      <v-btn size="30" block>attendance check list</v-btn>
    <!-- <h2>Attendance Check List</h2> -->
    <br />
    <div>
      <select
        class="form-select mb-3"
        aria-label="Default select example"
        style="width: 30%"
        v-model="selectedClass"
        @click="getStudentInClass(selectedClass)"
      >
        <option selected disabled>Select grade</option>
        <option v-for="grade in grades" :key="grade.value" :value="grade.value">
          {{ grade.label }}
        </option>
      </select>
    </div>
    <div class="checkToday">
      <!-- <input
        type="checkbox"
        class="selectattendance"
        @click="SelectAttendace()"
      />Attendance Today
      {{ this.date }} -->
      <v-checkbox
            @click="SelectAttendace()"
            value="red"
            label="Attendance Today"
            hide-details
          ></v-checkbox>{{ this.date }}
          
    </div>

    <table>
      <thead>
        <tr>
          <th>Selected</th>
          <th>FirstName</th>
          <th>LastName</th>
          <th>Gender</th>
          <th>Status</th>
          <th>Reason</th>
        </tr>
      </thead>
      <tbody v-if="students && students.length">
        <tr v-for="student in students" :key="student.id">
          <td class="text-center">
            <!-- <input
              @click="getChatId(student.id)"
              type="checkbox"
              class="selectstudent"
              v-model="student.selected"
            /> -->
            <v-checkbox
              @click="getChatId(student.id)"
              v-model="student.selected"
              color="red"
              value="red"
              hide-details
          ></v-checkbox>
          </td>
          <td>{{ student.first_name }}</td>
          <td>{{ student.last_name }}</td>
          <td>{{ student.gender }}</td>
          <td>
            <div class="dropdown rounded-1">
              <select
                class="form-select align-self-end"
                v-model="student.status"
                aria-label="Default select example"
                id="validationCustom01"
              >
                <option selected disabled>Select status</option>
                <option value="Present">Present</option>
                <option value="Absent">Absent</option>
                <option value="Early">Early</option>
                <option value="Excused">Excused</option>
                <option value="Unexcused">Unexcused</option>
                <option value="On leave">On leave</option>
                <option value="No show">No show</option>
              </select>
            </div>
          </td>
          <td>
            <textarea
              type="tel"
              v-model="student.reason"
              class="form-control"
              id="reason"
              placeholder=""
            />
          </td>
        </tr>
      </tbody>
      <tr v-else>
        <td colspan="6" class="text-center text-danger">
          This class does not have any students.
        </td>
      </tr>
    </table>

    <div class="col-12 d-flex justify-content-end btn">
      <button
        type="submit"
        class="btn btn-primary text-white"
        @click="submitForm()"
      >
        Save
      </button>
    </div>
  </v-card>
  </div>
</template>
<script>
import swal from "sweetalert2";
import axios from "axios";
import http from '../../htpp.common'
export default {
  name: "SweetAlert2",
  data() {
    return {
      students: [],
      date: null,
      chat_id: null,
      URL: "http://127.0.0.1:8000/api/checkStudentAttendance",
      gurdianURL: "http://127.0.0.1:8000/api/getGuardian",
      getClassURL:"http://127.0.0.1:8000/api/getuserInClass",
      grades: [
        { label: "Grade 9A", value: "9A" },
        { label: "Grade 9B", value: "9B" },
        { label: "Grade 9C", value: "9C" },
        { label: "Grade 10A", value: "10A" },
        { label: "Grade 10B", value: "10B" },
        { label: "Grade 10C", value: "10C" },
        { label: "Grade 11A", value: "11A" },
        { label: "Grade 11B", value: "11B" },
        { label: "Grade 11C", value: "11C" },
        { label: "Grade 12A", value: "12A" },
        { label: "Grade 12B", value: "12B" },
        { label: "Grade 12C", value: "12C" },
      ],
    };
  },
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
      this.students.forEach((student) => {
        student.status = false;
      });
    },
    async saveListAttendence() {
      try {
        const responses = await Promise.all(
          this.students.map((student) => {
            if (
              student.status !== "" &&
              student.reason !== "" &&
              this.date !== null
            ) {
              const newAttend = {
                attendance_status: student.status,
                date: this.date,
                reason: student.reason,
              };
              // console.log(newAttend);
              return axios.post(this.URL, newAttend);
            } else {
              swal.fire("Complete first", "complete all input", "info");
            }
          })
        );
        console.log(responses);
        swal.fire({
          icon: "success",
          title: "Save attendance successfully!",
          text: "you already save your attendance",
          timer: 2000,
        });
      } catch (error) {
        console.error(error);
        swal.fire("Error", "Failed to save attendance", "error");
      }
    },

    // ASk AI and copy from it "how to sent attendance of stundet to parent"
    // https://www.youtube.com/watch?v=aNmRNjME6mE
    async getChatId(id) {
      try {
        const response = await axios.get(this.gurdianURL + `/${id}`);
        this.chat_id = response.data.chat_id;
        console.log(this.chat_id);
      } catch (error) {
        console.error("Error getting chat ID:", error);
      }
    },

    async submitForm() {
      try {
        const telegramAPI =
          "https://api.telegram.org/bot6394729253:AAEuIrWM_GEvRqJ5kJ6Mpk4ZB7J0lmKMnfI/sendMessage"; // replace <bot_token> with your Telegram bot token
        const selectedStudents = this.students.filter(
          (student) =>
            student.selected && student.status !== "" && student.reason !== ""
        );
        if (selectedStudents.length === 0) {
          swal.fire("Error", "Please select at least one student", "error");
          return;
        }
        for (const student of selectedStudents) {
          await this.getChatId(student.id); // pass the guardian_id as the parameter
          const message = `Name: ${student.first_name} ${student.last_name}\nGender: ${student.gender}\nStatus: ${student.status}\nReason: ${student.reason}`;
          const response = await axios.post(telegramAPI, {
            chat_id: this.chat_id,
            text: message,
          });
          console.log(response);
          if (!response.data.ok) {
            swal.fire("Failed", "Failed to send message", "error");
            return;
          }
          // Create an attendance object for the current student
          const attendanceData = {
            user_id: student.id,
            status: student.status,
            reason: student.reason,
            date: this.date,
          };
          console.log(attendanceData);
          // Send the attendance data to your API
          axios
            .post(this.URL, attendanceData)
            .then((response) => {
              console.log(response.data);
              // Redirect the user to the attendance list page
              this.$router.push({ path: "/attendance_list" });
            })
            .catch((error) => {
              console.log(error);
            });
        }
        swal.fire({
          icon: "success",
          title: "Message sent successfully!",
          text: "Your attendance has been saved and the message has been sent to the guardian",
          timer: 2000,
        });
      } catch (error) {
        console.error("Error sending message:", error);
        swal.fire("Error", "Failed to send message", "error");
      }
    },

    getStudentData() {
      http.get('/api/get-students')
      .then((response) => {
        this.students = response.data.data;
      });
    },
    getStudentInClass(classId) {
      axios
        .get(this.getClassURL + "/" +`${classId}`)
        .then((response) => {
          this.students = response.data.data;
          console.log(this.students);
          for (let user of this.students) {
            this.students = user.students;
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },

  created() {
    setInterval(this.getCurrentDateTime, 1000);
  },
  mounted() {
    this.getStudentData();
  },
};
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
.btn {
  margin-right: 0.5%;
}

.selectattendance {
  padding: 10px;
  margin-left: 34px;
}

.container{
  width: 84%;
  margin-left: 17%;
}
</style>
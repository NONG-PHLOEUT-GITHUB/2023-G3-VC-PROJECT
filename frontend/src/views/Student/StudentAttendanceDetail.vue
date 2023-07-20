<template>
  <main class="table">
    <h3>
      Attendance Records for
      <span> {{ user.first_name }} {{ user.last_name }}</span>
    </h3>
    <table>
      <thead>
        <tr>
          <th>date</th>
          <th>reason</th>
          <th>attendance status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="record in attendanceRecords" :key="record.id">
          <td>{{ record.date }}</td>
          <td>{{ record.reason }}</td>
          <td>{{ record.status }}</td>
        </tr>
      </tbody>
    </table>
    <button @click="generatePDF()" class="button">save</button>
  </main>
</template>

<script>
import axios from "axios";
import swal from "sweetalert2";
import jsPDF from "jspdf";
import "jspdf-autotable";
export default {
  data() {
    return {
      user: {},
      attendanceRecords: [],
      URL: "http://127.0.0.1:8000/api/getAttendance",
      gurdianURL: "http://127.0.0.1:8000/api/getGuardian",
      pdfFile: null,
      telegramAPI:
        "https://api.telegram.org/bot6394729253:AAEuIrWM_GEvRqJ5kJ6Mpk4ZB7J0lmKMnfI/sendDocument", // replace with your Telegram bot token
    };
  },
  methods: {
    listattendance(id) {
      axios
        .get(this.URL + "/" + id)
        .then((response) => {
          this.user = response.data.user;
          this.attendanceRecords = response.data.attendanceRecords;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async getChatId(id) {
      try {
        const response = await axios.get(
          this.gurdianURL + "/" +`${id}`
        );
        this.chat_id = response.data.chat_id;
      } catch (error) {
        console.error("Error getting chat ID:", error);
      }
    },
    // -----------ASK AI "how to sent pdf file to telagrambot"==================
    async sendPDF(chatId, pdfOutput) {
      try {
        const formData = new FormData();
        formData.append("chat_id", chatId);
        formData.append("document", pdfOutput, "attendance.pdf");
        const response = await axios.post(this.telegramAPI, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });
        console.log(pdfOutput);
        if (!response.data.ok) {
          swal.fire("Failed", "Failed to send PDF", "error");
          return;
        }
        swal.fire({
          icon: "success",
          title: "PDF sent successfully!",
          text: "Your attendance report has been sent to the guardian",
          timer: 2000,
        });
      } catch (error) {
        console.error("Error sending PDF:", error);
        swal.fire("Error", "Failed to send PDF", "error");
      }
    },
    async generatePDF() {
      const document = new jsPDF("p", "pt", "a4");
      document.setFontSize(16);
      document.setFont("helvetica", "bold");
      document.text("Attendance Records ", 40, 30);
      const name = `${this.user.first_name} ${this.user.last_name}`;
      document.text(`FullName: ${name}`, 230, 30);
      const table = this.attendanceRecords.map((record) => [
        record.date,
        record.reason,
        record.status,
      ]);
      document.autoTable({
        head: [["Date", "Reason", "Attendance Status"]],
        body: table,
      });
      console.log(table);
      const pdfOutput = document.output("blob");
      await this.sendPDF(this.chat_id, pdfOutput);
      const fileName = `${name}_attendance.pdf`;
      document.save(fileName);
    },
  },
  mounted() {
    const id = this.$route.params.id;
    this.listattendance(id);
    this.getChatId(id);
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
  border-radius: 10px;
  padding: 2%;
}
h3 {
  margin-bottom: 10px;
  text-transform: uppercase;
  color: #0000ff;
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
  background-color: #0000ff;
  cursor: pointer;
  text-transform: uppercase;
  color: white;
  font-size: 15px;
  font-weight: bold;
}

.status.detail {
  padding: 0.4rem 1.5rem;
  border-radius: 2rem;
  text-align: center;
  background-color: #50ded9;
  color: #006b21;
}
thead th:hover {
  color: #e2f0ee;
}
.button {
  background: blue;
  border: none;
  border-radius: 20px;
  color: #fff;
  cursor: pointer;
  font-weight: 600;
  padding: 10px 22px;
  text-transform: uppercase;
  transition: all 0.3s ease-in-out;
  margin-top: 10px;
  margin-left: 93%;
}
</style>
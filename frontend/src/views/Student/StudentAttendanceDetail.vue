<template>
  <admin-dashboard></admin-dashboard>
  <main class="table">
    <h3>
      Attendance Records
      <span> {{ user.first_name }} {{ user.last_name }}</span>
    </h3>
    <v-table class="mt-4">
      <thead>
        <tr class="bg-primary">
          <th class="text-white fs-6">date</th>
          <th class="text-white fs-6">reason</th>
          <th class="text-white fs-6">attendance status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="record in attendanceRecords" :key="record.id">
          <td>{{ record.date }}</td>
          <td>{{ record.status }}</td>
          <td>{{ record.reason }}</td>
        </tr>
      </tbody>
    </v-table>
  </main>
    <button @click="generatePDF()" class="button">save</button>
</template>

<script>
import axios from "axios";
import swal from "sweetalert2";
import jsPDF from "jspdf";
import http from '../../htpp.common'
import "jspdf-autotable";
export default {
  data() {
    return {
      user: {},
      attendanceRecords: [],
      pdfFile: null,
      telegramAPI:
        "https://api.telegram.org/bot6394729253:AAEuIrWM_GEvRqJ5kJ6Mpk4ZB7J0lmKMnfI/sendDocument", // replace with your Telegram bot token
    };
  },
  methods: {
    listattendance(id) {
      http
        .get('/getAttendance' + "/" + id)
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
        const response = await http.get('/guardian' + "/" + `${id}`);
        this.chat_id = response.data.guardian_id;
        console.log(response.data.guardian_id);
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

main {
  margin-top: 10px;
  margin-left: 19%;
}
.button {
  margin-left: 90%;
  border: 1px solid gray;
  width: 10%;
  padding: 9px;
  margin-top: 10px;
  background: blue;
  color: white;
  border-radius: 10px;
}
</style>
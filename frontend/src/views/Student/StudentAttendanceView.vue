<template>
  <student-dashboard />
  <v-card class="card mt-3">
    <v-tabs 
      v-model="tab"
      bg-color="deep-purple-darken-4"
      center-active
    >
      <v-tab value="1">January</v-tab>
      <v-tab value="2">February</v-tab>
      <v-tab value="3">March</v-tab>
      <v-tab value="4">April</v-tab>
      <v-tab value="5">May</v-tab>
      <v-tab value="6">June</v-tab>
      <v-tab value="7">July</v-tab>
      <v-tab value="8">August</v-tab>
      <v-tab value="9">September</v-tab>
      <v-tab value="10">October</v-tab>
      <v-tab value="11">November</v-tab>
      <v-tab value="12">December</v-tab>
    </v-tabs>
  </v-card>
  <v-card-text class="card">
      <v-window v-model="tab">
        <v-window-item value="1">
          <div class="table-responsive">
            <table class="table table-hover table-nowrap mt-2">
              <thead class="bg-primary">
                <tr>
                  <th scope="col" class="text-sm text-light">Date</th>
                  <th scope="col" class="text-sm text-light">status</th>
                  <th scope="col" class="text-sm text-light">Reason</th>
                  <th scope="col" class="text-sm text-light">Subject</th>
                  <th scope="col" class="text-sm text-light">Teacher</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="attendance of attendances"
                  :key="attendance"
                  class="border-2-dark"
                >
                  <td class="text-sm text-black">{{ attendance.date}}</td>
                  <td class="text-sm text-black">{{ attendance.status}}</td>
                  <td class="text-sm text-black">{{ attendance.reason}}</td>
                  <td class="text-sm text-black">{{ attendance.subject}}</td>
                  <td class="text-sm text-black">{{ attendance.teacher }}</td>
                </tr>
              </tbody>
            </table>
            <div class="download d-flex justify-content-end mt-3">
              <button
                class="btn btn-sm btn-neutral text-white text-dark-hover bg-primary p-4 fs-6 align-self-end"
                v-if="!isDownloading"
                @click="downloadPDF()"
              >
                <i class="bi bi-download"></i> Download PDF
              </button>
              <div v-else>
                <p>Generating PDF...</p>
                <i class="fa fa-spinner fa-spin"></i>
              </div>
              <a v-if="pdfUrl" :href="pdfUrl" download="file.pdf"></a>
            </div>
          </div>
        </v-window-item>

        <v-window-item value="2">
          Two
        </v-window-item>

        <v-window-item value="3">
          Three
        </v-window-item>
      </v-window>
  </v-card-text>
</template>
<script>
import axios from "axios";
import jsPDF from "jspdf";
import html2canvas from "html2canvas";
export default {
  data: () => ({
    tab: null,
    isDownloading: false,
    isDetail: false,
    pdfUrl: null,
    url: "http://127.0.0.1:8000/api/getTeachers",
    attendances: [
      {date: "01", status: "Absent", reason: "Wedding sister", subject: "English", teacher: "Linna Muth"},
      {date: "02", status: "Absent", reason: "no", subject: "English", teacher: "Linna Muth"},
      {date: "03", status: "Absent", reason: "Sick", subject: "English", teacher: "Linna Muth"},
      {date: "04", status: "Absent", reason: "no", subject: "English", teacher: "Linna Muth"},
      {date: "05", status: "Absent", reason: "no", subject: "English", teacher: "Linna Muth"},
    ]
  }),
  methods: {
    downloadPDF() {
    this.isDetail = true;
    axios
      .get(this.url)
      .then((response) => {
        this.attendances = response.data.data;
        const element = document.querySelector(".table");
        html2canvas(element).then((canvas) => {
          const imgData = canvas.toDataURL("image/png");
          const pdf = new jsPDF();
          const imgProps = pdf.getImageProperties(imgData);
          const pdfWidth = pdf.internal.pageSize.getWidth();
          const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
          pdf.addImage(imgData, "JPEG", 0, 0, pdfWidth, pdfHeight);
          pdf.save("download.pdf");
          this.isDetail = false;
          this.fetchData();
        });
      })
      .catch((error) => {
        console.error(error);
      });
    },
    fetchData() {
      axios
        .get(this.url)
        .then((response) => {
          this.teachers = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.fetchData();
  },
}
</script>
  
<style>
  @import "~vuetify/dist/vuetify.css";
.card{
  margin-left: 17%;
}
.table th {
  font-size: 20px;
}
</style>
  
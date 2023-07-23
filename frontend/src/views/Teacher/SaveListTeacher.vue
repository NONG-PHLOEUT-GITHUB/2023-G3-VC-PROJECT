<template>
  <admin-dashboard></admin-dashboard>
  <div class="teacher-list mt-4">
    <h3>TEACHERS' LIST</h3>
    <div class="table-responsive">
      <table class="table table-hover table-nowrap mt-3">
        <thead class="bg-primary">
          <tr>
            <th scope="col" class="fs-6 text-light">NO</th>
            <th scope="col" class="fs-6 text-light">Name</th>
            <th scope="col" class="fs-6 text-light">Gender</th>
            <th scope="col" class="fs-6 text-light">age</th>
            <th scope="col" class="fs-6 text-light">Date of birth</th>
            <!-- <th scope="col" class="fs-6 text-light">Class</th>
            <th scope="col" class="fs-6 text-light">Subject</th> -->
            <th scope="col" class="fs-6 text-light">Phone number</th>
            <th scope="col" class="fs-6 text-light">Address</th>
            <th scope="col" class="fs-6 text-light">Email</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(teacher, index) of teachers"
            :key="index"
            class="border-2-dark"
          >
            <td>{{ index + 1 }}</td>
            <td>{{ teacher.first_name + " " + teacher.last_name }}</td>
            <td>{{ teacher.gender }}</td>
            <td>{{ teacher.age }}</td>
            <td>{{ teacher.date_of_birth }}</td>
            <!-- <td>{{ teacher.class }}</td>
            <td>{{ teacher.subject }}</td> -->
            <td>{{ teacher.phone_number }}</td>
            <td>{{ teacher.address }}</td>
            <td>{{ teacher.email }}</td>
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
  </div>
</template>

<script>
import axios from "axios";
import jsPDF from "jspdf";
import html2canvas from "html2canvas";
import http from "../../htpp.common";
export default {

  data() {
    return {
      isDownloading: false,
      isDetail: false,
      pdfUrl: null,
      teachers: [],
    };
  },
  methods: {
    // download pdf ==================================
    downloadPDF() {
      this.isDetail = true;
      axios
        .get(this.url)
        .then((response) => {
          this.teachers = response.data.data;
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
      http
        .get('/api/get-teachers')
        .then((response) => {
          this.teachers = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.fetchData();
  },
};
</script>

<style scoped>
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,600,700);

/* Bootstrap Icons */
@import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");

.teacher-list{
  /* background:blue; */
  margin-left: 18%;
}
</style>

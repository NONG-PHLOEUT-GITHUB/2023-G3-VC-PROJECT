<template>
  <div>
    <h3>STUDENT LIST</h3>
    <div class="table-container">
      <table id="my-table">
        <v-table>
          <thead>
            <tr>
              <th class="text-white">No</th>
              <th class="text-white">FirstName</th>
              <th class="text-white">LastName</th>
              <th class="text-white">Gender</th>
              <th class="text-white">Age</th>
              <th class="text-white">DateofBirth</th>
              <th class="text-white">PhoneNumber</th>
              <th class="text-white">Address</th>
              <th class="text-white">Email</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(student, index) in students" :key="index">
              <td>{{ index + 1 }}</td>
              <td>{{ student.first_name }}</td>
              <td>{{ student.last_name }}</td>
              <td>{{ student.gender }}</td>
              <td>{{ student.age }}</td>
              <td>{{ student.date_of_birth }}</td>
              <td>{{ student.phone_number }}</td>
              <td>{{ student.address }}</td>
              <td>{{ student.email }}</td>
            </tr>
          </tbody>
        </v-table>
      </table>
      <button class="button" v-if="!isDownloading" @click="downloadPDF()">
        <i class="bi bi-download"></i> Download PDF
      </button>
      <div v-else>
        <p>Generating PDF...</p>
        <i class="fa fa-spinner fa-spin"></i>
      </div>
      <a v-if="pdfUrl" :href="pdfUrl" download="file.pdf"></a>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import jsPDF from "jspdf";
import html2canvas from "html2canvas";
export default {
  data() {
    return {
      isDownloading: false,
      isDetail: false,
      pdfUrl: null,
      students: [],
      url: "http://127.0.0.1:8000/api/getStudents",
    };
  },
  // reference https://stackoverflow.com/questions/63789573/html2canvas-with-jspdf-in-vue-cli-application-dont-work and with AI
  methods: {
    // download pdf ==================================
    downloadPDF() {
      this.isDetail = true;
      axios
        .get(this.url)
        .then((response) => {
          this.students = response.data.data;
          const element = document.getElementById("my-table");
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
          this.students = response.data;
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


/* Set styles for the table */
table {
  border-collapse: collapse;
  width: 100%;
  margin-bottom: 20px;
}

td {
  text-align: left;
  padding: 8px;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: blue;
  color: white;
}

/* Set styles for the download button */
.button {
  border: none;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin-top: 20px;
  cursor: pointer;
}
.fa-spinner {
  font-size: 24px;
  margin-left: 10px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
.detail {
  background: #58c3e7;
  border: none;
  border-radius: 20px;
  color: #fff;
  cursor: pointer;
  font-weight: 600;
  padding: 8px 20px;
  text-transform: uppercase;
  transition: all 0.3s ease-in-out;
}

.detail:hover {
  background: #fff;
  color: #add8e6;
}

.button {
  background: blue;
  border: none;
  color: #fff;
  cursor: pointer;
  font-weight: 600;
  padding: 10px 22px;
  margin-top: 10px;
  margin-left: 88%;
}

.button:hover {
  background: #fff;
  color: #add8e6;
}

.button-container {
  text-align: left;
}
</style>
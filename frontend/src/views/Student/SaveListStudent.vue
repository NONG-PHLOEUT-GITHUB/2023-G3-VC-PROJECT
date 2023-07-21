<template>
  <div>
    <h3>STUDENT LIST</h3>
    <div class="table-container">
      <table id="my-table">
        <thead class="bg-primary">
          <tr>
            <th>No</th>
            <th>FirstName</th>
            <th>LastName</th>
            <th>Gender</th>
            <th>Age</th>
            <th>DateofBirth</th>
            <th>PhoneNumber</th>
            <th>Address</th>
            <th>Email</th>
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

.table-container {
  font-family: "Poppins", sans-serif;
  margin: 0 auto;
  margin-top: 10px;
}

#my-table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
}

#my-table th,
#my-table td {
  padding: 15px;
  text-align: center;
}

#my-table th {
  border-bottom: 2px solid #fff;
  color: #fff;
  font-weight: 600;
  text-transform: uppercase;
  border: 1px solid #ddd;
}

#my-table td {
  border-bottom: 1px solid #ddd;
  border: 1px solid #ddd;
}

#my-table tr:last-child td {
  border-bottom: none;
  border: 1px solid #ddd;
}

#my-table tr:nth-child(even) td {
  background-color: #f4f4f4;
  border: 1px solid #ddd;
}

#my-table tr:hover td {
  background-color: #eaeaea;
  border: 1px solid #ddd;
}

@media only screen and (max-width: 768px) {
  .my-table {
    font-size: 0.9rem;
  }
}

.my-table td:nth-child(2),
.my-table td:nth-child(3) {
  text-align: left;
}

.my-table td:nth-child(2) {
  color: #add8e6;
}

.my-table td:nth-child(3) {
  color: #999;
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
  border-radius: 20px;
  color: #fff;
  cursor: pointer;
  font-weight: 600;
  padding: 10px 22px;
  text-transform: uppercase;
  transition: all 0.3s ease-in-out;
  margin-top: 10px;
  margin-left: 83%;
}

.button:hover {
  background: #fff;
  color: #add8e6;
}

.button-container {
  text-align: left;
}

.fa-spinner {
  animation: fa-spin 2s infinite linear;
}

@keyframes fa-spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
<template>
  <div >
    <table id="my-file">
        <div class="div">
            
        </div>
      <thead>
        <tr>
          <th>User_id</th>
          <th>FirstName</th>
          <th>LastName</th>
          <th>Gender</th>
          <th>Age</th>
          <th>DateOfBirth</th>
          <th>PhoneNumber</th>
          <th>Address</th>
          <th>Profile</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(student, index) in students" :key="index">
          <td>{{ student.user_id }}</td>
          <td>{{ student.first_name }}</td>
          <td>{{ student.last_name }}</td>
          <td>{{ student.gender }}</td>
          <td>{{ student.age }}</td>
          <td>{{ student.date_of_birth }}</td>
          <td>{{ student.phone_number }}</td>
          <td>{{ student.address}}</td>
          <td>{{ student.profile}}</td>
          <td>{{ student.email}}</td>
        </tr>
      </tbody>
      
    </table>
    <button class="button" v-if="!isDownloading" @click="downloadPDF()" >
        <img class="picture" src="../../assets/downloads.png">Download PDF
    </button>
    <div v-else>
      <p>Generating PDF...</p>
      <i class="fa fa-spinner fa-spin"></i>
    </div>
    <a v-if="pdfUrl" :href="pdfUrl" download="file.pdf" ></a>
  </div>
</template>

<script>
import axios  from "axios";
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
export default {
    data(){
        return{
            isDownloading: false,
            pdfUrl: null,
            students: [],
        }
    },
    methods: {
        downloadPDF() {
        axios({
        url: 'http://127.0.0.1:8000/api/users',
        method: 'GET',
        })
        .then(response => {
            this.students = response.data.data
        console.log(response.data.data);
        const element = document.getElementById('my-file');
        html2canvas(element).then((canvas) => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF();
            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

            pdf.addImage(imgData, 'JPEG', 0, 0, pdfWidth, pdfHeight);
            pdf.save('download.pdf');
        });
        })
        .catch(error => {
        console.error(error);
        });
        }
    },
    created() {
        axios
        .get("http://127.0.0.1:8000/api/users") // URL of the API endpoint to fetch data from
        .then((response) => {
            this.students = response.data.data;
        })
        .catch((error) => {
            console.log(error);
        });
  },

}
</script>

<style>
th{
    padding: 18px;
    background-color: rgb(245, 245, 245)  
}
td{
    padding: 18px;
}
#my-file{
    margin: auto;
    border: 1px solid grey;  
} 
.button{
    width: 14%;
    margin-left: 76%;
    margin-top: 10px;
    background-color:rgb(171, 179, 181);
    padding: 7px;
    border: 1px solid rgb(171, 179, 181);
    border-radius: 7px;
}
tr{
    border: 1px solid rgb(209, 215, 216);
}
.picture{
    width: 10%;
    margin-right: 8px;
}

</style>
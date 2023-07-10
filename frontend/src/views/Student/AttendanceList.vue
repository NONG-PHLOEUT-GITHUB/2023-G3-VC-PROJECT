<template>
  <div>
    <h1>Attendance Check List</h1>
    <div>
      <p>This is Attendance of Today</p>
    </div>
    <div>
        <button class="selectattendance" @click="SelectAttendace()">Attendance Today </button>
        {{selectedDate}}
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
            <input type="checkbox" v-model="student.status"> Present
          </td>
          <td>{{ student.reason }}</td>
        </tr>
      </tbody>
      
    </table>
    <button class="save" @click="showAlert()">Save</button>
     
  </div>
</template>

<script>
import swal from 'sweetalert2';
export default {
  name:'SweetAlert2',
  data() {
    return {
      students: [
        { id: 1, name: 'John', gender: 'Male',  reason: 'Sick', status: false },
        { id: 2, name: 'Jane', gender: 'Female',  reason: 'Sick', status: false },
        { id: 3, name: 'Bob', gender: 'Male',  reason: 'Sick', status: false },
        { id: 4, name: 'Sarah', gender: 'Female', reason: 'Sick', status: false }
      ],
      selectedDate: null,
      testButClicked: false,
      isHidden: true
    }
  },
  // copy by "https://stackoverflow.com/questions/57249466/getting-current-time-and-date-in-vue-js"
  methods: {
    SelectAttendace() {
      const today = new Date();
      const date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
      this.selectedDate = date;
      console.log(this.selectedDate)
      this.students.forEach((student) => {
        student.status = false;
      });
    },
    created() {
      setInterval(this.getNow, 1000);
    },
    showAlert() {
    // Use sweetalert2
      swal.fire({
        icon:'success',
        title:'Successfully',
      });
    },
    mounted(){
      this.getStudentData()
    }

   
  },
  
  
  
}
</script>



<style scoped>
table {
border-collapse: collapse;
width: 90%;
margin-top: 20px;
margin-bottom: 20px;
margin-left:5% ;
}

th, td {
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

h1,p{
    margin-left: 5%;
}
.save{
  padding: 10px;
  background: lightblue;
  border: 1px solid lightblue;
  width: 10%;
  margin-top: 10px;
  margin-left: 85%;
}
.selectattendance{
    padding: 10px;
    background: lightblue;
    border: 1px solid lightblue;
    margin-left: 65px;
}
</style>
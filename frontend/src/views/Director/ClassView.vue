<template>
  <div class="card shadow border-0 mb-7">
    <div class="card-header">
      <h3 class="mb-0 text-primary">CLASSES LIST</h3>
    </div>
    <div class="card-header">
      <div
        class="form-group d-flex justify-content-between mb-3"
        style="width: 100%"
      >
        <form class="form-inline my-2 my-lg-0 d-flex" style="width: 60%">
          <input
            class="form-control mr-sm-2"
            type="search"
            placeholder="Search class room"
            aria-label="Search"
            style="width: 78%"
            v-model="searchQuery"
          />
          <button
            class="btn btn-outline-warning my-2 my-sm-0"
            type="button"
            @click="searchClasses"
          >
            <i class="bi bi-search"></i> Search
          </button>
        </form>
        <router-link
          :to="{ path: '/createClass' }"
          class="text-white"
          style="width: 20%"
        >
          <button
            type="button"
            class="btn btn-primary align-self-end"
            style="width: 100%"
          >
            <i class="bi bi-building"></i> Add new class
          </button>
        </router-link>
      </div>
      
    </div>
    <div class="card-header">
      <h3 class="mb-0 p-0 text-primary">GRADE 10</h3>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-nowrap">
        <thead class="bg-primary">
          <tr>
            <th scope="col" class="fs-6 text-light">Class</th>
            <th scope="col" class="fs-6 text-light">Teacher</th>
            <th scope="col" class="fs-6 text-light">Total students</th>
            <th scope="col" class="fs-6 text-light">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr @click="showStudents(classRoom.name)" v-for="classRoom in listClasses" :key="classRoom.name" class="border-2-dark">
            <!-- <div v-if="selectedClass">
              <student-list :selectedClass="selectedClass" />
          </div> -->
            <td>
              <i class="bi bi-building"></i>
              {{classRoom.class_name}}
              
            </td>  
            <td>
              {{ classRoom.user_id }}
            </td>
            <td>
              {{ numberStudent }}
            </td>
            <td  class="text-end d-flex justify-content-start">
              <router-link :to="{ path: '/monthly_report' }">
                <button
                  type="button"
                  class="btn btn-sm btn-neutral text-dark text-primary-hover bg-gray-300"
                >
                  <i class="bi bi-table text-warning"></i> View Score List
                </button>
              </router-link>
              <router-link :to="{ path: '/attendance_list' }">
                <button
                  type="button"
                  class="btn btn-sm btn-neutral text-dark text-primary-hover ml-2 bg-gray-300"
                >
                  <i class="bi bi-calendar2-week-fill text-warning"></i> Show
                  list Attendace
                </button>
              </router-link>
              <router-link :to="{ path: '/checkAttendance' }">
                <button
                  type="button"
                  class="btn btn-sm btn-neutral text-dark text-primary-hover ml-2 bg-gray-300"
                >
                  <i class="bi bi-calendar2-week-fill text-warning"></i> Check
                  Attendance
                </button>
              </router-link>
            </td>
          </tr>      
        </tbody>          
        
      </table>
    </div>
    <div class="card-header">
          <div class="form-group d-flex justify-content-between mb-3" style="width: 100%;">
            <form class="form-inline my-2 my-lg-0 d-flex" style="width: 100%;">
              <div v-if="selectedClass">
                <student-list :selectedClass="selectedClass" />

              </div>
            </form>
        </div>
    </div>
  </div>

</template>

<script>
import axios from 'axios';
import StudentList from '../Director/StudentList.vue'; // Import the StudentList component

export default {
  components: {
    StudentList, // Register the StudentList component
  },
  data() {
    return {
      students:[],
      // classesList: [
      //   { name: " 10A", students: 53, teacher: "Sreypok Doem" },
      //   { name: " 10B", students: 53, teacher: "Sreypok Doem" },
      //   { name: " 10C", students: 53, teacher: "Sreypok Doem" },
      //   { name: " 10D", students: 53, teacher: "Sreypok Doem" },
      //   { name: " 10E", students: 53, teacher: "Sreypok Doem" },
      //   { name: " 11A", students: 50, teacher: "Sokunthea Kim" },
      //   { name: " 11B", students: 50, teacher: "Sokunthea Kim" },
      //   { name: " 11C", students: 50, teacher: "Sokunthea Kim" },
      //   { name: " 11D", students: 50, teacher: "Sokunthea Kim" },
      //   { name: " 11E", students: 50, teacher: "Sokunthea Kim" },
      //   { name: " 12A", students: 48, teacher: "Ratana Lim" },
      //   { name: "12B", students: 48, teacher: "Ratana Lim" },
      //   { name: " 12C", students: 48, teacher: "Ratana Lim" },
      //   { name: " 12D", students: 48, teacher: "Ratana Lim" },
      //   { name: " 12E", students: 48, teacher: "Ratana Lim" }
      // ],
      listClasses: [],
      numberStudent: 0,
      URL: "http://127.0.0.1:8000/api/classes",
      searchQuery: '',
      selectedClass: '',
    };
  },
  computed: {
    filteredClassesList() {
      // Filter the classes list based on the search query
      return this.listClasses.filter(classRoom => classRoom.name.toLowerCase().includes(this.searchQuery.toLowerCase()));
    },
  },
  methods: {
    getURL() {
      axios.get(this.URL).then((response) => {
          this.listClasses = response.data.data;
          console.log(this.listClasses);
      });
    },
    showStudents(className) {
    // Set the selected class to the class name that was clicked
    this.selectedClass = className;

    axios.get(`http://127.0.0.1:8000/api/getClassStudents?class_name=${className}`)
      .then(response => {
        console.log(response.data.data);
        // Set the students list to the response data
        this.listClasses = response.data.data;
      })
      .catch(error => {
        // Handle the error here
        console.log(error);
      });
    },
  },
  mounted() {
    return this.getURL();
  },
};
</script>
<template>
  <div class="card shadow border-0 mb-7">
    <div class="card-header">
      <h3 class="mb-0 text-primary">CLASSES LIST</h3>
    </div>
    <div class="card-header">
      <div class="form-group d-flex justify-content-between mb-3">
       <select name="" id="" class="form-select mb-3 w-25" aria-label="Default select example">
        <option value="">Grade 10A</option>
        <option value="">Grade 10A</option>
       </select>
        <router-link :to="{ path: '/createClass' }" class="text-white">
          <button type="button" class="btn btn-primary align-self-end">
            <i class="bi bi-building"></i> Add new class
          </button>
        </router-link>
      </div>

    </div>
    <div class="table-responsive">
      <table class="table table-hover table-nowrap">
        <tbody>
          <tr @click="showStudents(classRoom.name)" v-for="classRoom in listClasses" :key="classRoom.name"
            class="border-2-dark">
            <td>
              <i class="bi bi-building"></i>
              {{ classRoom.class_name }}

            </td>
            <td>
              {{ classRoom.user_id }}
            </td>
            <td>
              {{ numberStudent }}
            </td>
            <td class="text-end d-flex justify-content-start">
              <router-link :to="{ path: '/monthly_report' }">
                <button type="button" class="btn btn-sm btn-neutral text-dark text-primary-hover bg-gray-300">
                  <i class="bi bi-table text-warning"></i> Score report
                </button>
              </router-link>
              <router-link :to="{ path: '/attendance_list' }">
                <button type="button" class="btn btn-sm btn-neutral text-dark text-primary-hover ml-2 bg-gray-300">
                  <i class="bi bi-calendar2-week-fill text-warning"></i> Attendance report
                </button>
              </router-link>
            </td>
          </tr>
        </tbody>

      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
// import StudentList from '../Student/StudentList.vue'; // Import the StudentList component

export default {
  // components: {
  //   StudentList, // Register the StudentList component
  // },
  data() {
    return {
      students: [],
      listClasses: [],
      numberStudent: 0,
      URL: "http://127.0.0.1:8000/api/classes",
      searchQuery: '',
      selectedClass: '',
    };
  },
  // computed: {
  //   filteredClassesList() {
  //     // Filter the classes list based on the search query
  //     return this.listClasses.filter(classRoom => classRoom.name.toLowerCase().includes(this.searchQuery.toLowerCase()));
  //   },
  // },
  methods: {
    getURL() {
      axios.get(this.URL).then((response) => {
        this.listClasses = response.data.data;
        console.log(this.listClasses);
      });
    },
    showStudents() {
      axios.get(`http://127.0.0.1:8000/api/getuserInClass`)
        .then(response => {
          console.log(response.data);
          this.error = null;
        })
        .catch(error => {
          this.studentName = null;
          this.error = error.response.data.error;
        });

    },
  },
  mounted() {
    return this.getURL();
  },
};
</script>
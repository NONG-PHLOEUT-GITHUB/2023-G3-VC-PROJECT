<template>
  <div class="card shadow border-0 mb-7">
    <div class="card-header">
      <h3 class="mb-0 text-primary">TEACHERS LIST</h3>
    </div>
    <div class="card-header">
      <select class="form-select mb-3" aria-label="Default select example" style="width: 30%;">
        <option selected disabled>Select grade</option>
        <option value="10">Grade 10</option>
        <option value="11">Grade 11</option>
        <option value="12">Grade 12</option>
      </select>
      <div class="form-group d-flex justify-content-between mb-3" style="width: 100%;">
        <form class="form-inline my-2 my-lg-0 d-flex" style="width: 60%;">
          <input class="form-control mr-sm-2" type="search" placeholder="Search student" aria-label="Search"
            style="width: 78%;">
          <button class="btn btn-outline-warning my-2 my-sm-0 " type="button"><i class="bi bi-search"></i> Search</button>
        </form>
        <form class="input-file ms-4 me-3 border border-4 rounded-1 p-2 " @submit.prevent="importFile">
          <label for="file-input">Upload Excel file</label>
          <input type="file" ref="fileInput" id="file-input">
          <i class="bi bi-cloud-arrow-up ms-2 mt-4"></i>
        </form>
        <router-link :to="{ path: '/createUser' }" class="text-white">
          <button type="button" class="btn btn-primary align-self-end ms-2"><i class="bi bi-person-plus-fill"></i> Add new teacher</button></router-link>
      </div>
    </div>


    <div class="table-responsive">
      <table class="table table-hover table-nowrap">
        <thead class="bg-primary">
          <tr>
            <th scope="col" class="fs-6 text-light">Name</th>
            <th scope="col" class="fs-6 text-light">Gender</th>
            <th scope="col" class="fs-6 text-light">age</th>
            <th scope="col" class="fs-6 text-light">class</th>
            <th scope="col" class="fs-6 text-light">Subject</th>
            <th scope="col" class="fs-6 text-light">phone number</th>
            <th scope="col" class="fs-6 text-light">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(teacher, index) of filteredTeacherList" :key="index" class="border-2-dark">
            <td>
              <img alt="..." :src="teacher.profile" class="avatar avatar-sm rounded-circle me-2">
              <a class="text-heading font-semibold" href="#">{{teacher.first_name + " " + teacher.last_name}}</a>
            </td>
            <td>{{teacher.gender}}</td>
            <td>{{teacher.age}}</td>
            <td>{{teacher.class}}</td>
            <td>{{teacher.subject}}</td>
            <td>{{teacher.phone_number}}</td>

            <td class="text-end d-flex justify-content-end">
              <router-link :to="{ path: '/student_detail/' + teacher.id }">
                <button type="button" class="btn btn-sm btn-neutral text-dark text-primary-hover bg-gray-300">
                  <i class="bi bi-person-circle text-warning"></i> View Profile
                </button>
              </router-link>

              <router-link :to="{ path: '/edit/' + teacher.id }">
                <button type="button" class="btn btn-sm btn-neutral text-white text-dark-hover bg-warning ml-2">
                  <i class="bi bi-pencil-square"></i> Edit
                </button>
              </router-link>

              <button type="button" class="btn btn-sm btn-neutral text-white text-dark-hover bg-danger ml-2"
                @click="deleteUser(teacher.id)">
                <i class="bi bi-trash-fill"></i> Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>

import axios from "axios";
import swal from "sweetalert";
import Swal from "sweetalert2";
import http from "../../htpp.common"
export default {
  data() {

    return {
      URL: "http://127.0.0.1:8000/api/getTeachers",
      teacherList: [],
      errorMessage: "",
      searchQuery: "",
    }
  },

  computed: {
    filteredTeacherList() {
      if (this.searchQuery === "") {
        return this.teacherList;
      } else {
        const filtered = this.teacherList.filter(teacher =>
          (teacher.first_name + ' ' + teacher.last_name).toLowerCase().includes(this.searchQuery.trim().toLowerCase())
        );
        if (filtered.length === 0) {
          return [{ first_name: "teacher not found", last_name: "", email: "", phone_number: "", etc: "" }];
        } else {
          return filtered;
        }
      }
    },
  },
  methods: {
    //===================get data from Database =================
    getData() {
      axios.get(this.URL).then((response) => {
        this.teacherList = response.data;
        console.log(this.teacherList);
      });
    },
    //================== Delete a user =================
    deleteUser(id) {
      swal({
        title: "Are you sure?",
        text: "You will not be able to recover this user!",
        icon: "warning",
        buttons: ["Cancel", "Yes, delete it!"],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          axios.delete(this.URL + `/${id}`)
            .then(() => {
              swal("Deleted!", "Your user has been deleted.", "success");
              // call mounted
              this.getData();
            })
            .catch(error => {
              swal("Error", "An error occurred while deleting the user.", "error");
              console.error(error);
            });
        } 
      });
    },

    importFile() {
/// progressbar
      let timerInterval;
      Swal.fire({
        title: 'File Uploading',
        html: 'Please wait for file upload <b></b> %.',
        timer: 2000, // Change the timer to 5000ms (5 seconds)
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading();
          const b = Swal.getHtmlContainer().querySelector('b');
          let startTime = Date.now();
          timerInterval = setInterval(() => {
            let elapsedTime = Date.now() - startTime;
            let progress = Math.min(100, Math.round((elapsedTime / 20)));
            b.textContent = progress;
          }, 20);
        },
        willClose: () => {
          clearInterval(timerInterval);
        }
      }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
          console.log('I was closed by the timer');
        }
      });
      /// data upload

      const file = this.$refs.fileInput.files[0];
      const formData = new FormData();
      formData.append('file', file);

      http.post('/api/users-import', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }

      }).then(response => {
        console.log(response.data);

        /// progressbar
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })

        Toast.fire({
          icon: 'success',
          title: 'Upload successful',
        })
        // call mounted
        this.getData();

      }).catch(error => {
        console.error(error.response.data);
      });
    }
  },

  mounted() {
    this.$refs.fileInput.addEventListener('change', this.importFile);
    return this.getData();
  },
}
</script>

<style scoped>

</style>
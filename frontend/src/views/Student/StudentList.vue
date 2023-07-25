<template>
  <admin-dashboard></admin-dashboard>
  <div class="card shadow border-0 mb-7">
    <div class="card-header">
      <h3 class="mb-0 text-primary">STUDENTS LIST</h3>
    </div>
    <div class="card-header">
      <div>
        <select class="form-select mb-3" aria-label="Default select example" style="width: 30%" v-model="selectedClass"
          @click="getStudentInClass(selectedClass)">
          <option selected disabled>Select grade</option>
          <option v-for="grade in grades" :key="grade.value" :value="grade.value">
            {{ grade.label }}
          </option>
        </select>
      </div>
      <div class="form-group d-flex justify-content-between mb-3" style="width: 100%">
        <form class="form-inline my-2 my-lg-0 d-flex" style="width: 60%">
          <input class="form-control mr-sm-2" type="search" placeholder="Search student" aria-label="Search"
            style="width: 78%" />
          <button class="btn btn-outline-warning my-2 my-sm-0" type="button">
            <i class="bi bi-search"></i> Search
          </button>
        </form>
        <form class="input-file ms-4 me-3 border border-4 rounded-1 p-2" @submit.prevent="importFile">
          <label for="file-input">Upload Excel file</label>
          <input type="file" ref="fileInput" id="file-input" />
          <i class="bi bi-cloud-arrow-up ms-2 mt-4"></i>
        </form>
        <router-link :to="{ path: '/createUser' }" class="text-white">
          <button type="button" class="btn btn-primary align-self-end ms-2">
            <i class="bi bi-person-plus-fill"></i> Add new student
          </button></router-link>
      </div>
    </div>
    <div class="card-header">
      <h5 class="mb-0 p-0 text-primary">
        STUDENT LIST CLASS {{ selectedClass }}
      </h5>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-nowrap">
        <thead class="bg-primary">
          <tr>
            <th scope="col" class="fs-6 text-light">Name</th>
            <th scope="col" class="fs-6 text-light">Gender</th>
            <th scope="col" class="fs-6 text-light">Age</th>
            <th scope="col" class="fs-6 text-light">Email</th>
            <th scope="col" class="fs-6 text-light">Phone Number</th>
            <th></th>
          </tr>
        </thead>

        <tbody v-if="listUser && listUser.length">
          <tr v-for="(user, id) of listUser" :key="id" class="border-2-dark">
            <td>
              <img v-if="user.profile" :src="user.profile" class="avatar avatar-sm rounded-circle me-2">
              <img v-else src="https://assets.stickpng.com/thumbs/585e4beacb11b227491c3399.png"
                class="avatar avatar-sm rounded-circle me-2">
              <a class="text-heading font-semibold" href="#">
                {{ user.first_name }} {{ user.last_name }}
              </a>
            </td>
            <td>
              {{ user.gender }}
            </td>
            <td>
              {{ user.age }}
            </td>
            <td>
              {{ user.email }}
            </td>
            <td hidden>
              {{ user.password }}
            </td>
            <td>
              {{ user.phone_number }}
            </td>
            <td class="text-end d-flex justify-content-end">
              <router-link :to="{ path: '/student_detail/' + user.id }">
                <button type="button" class="btn btn-sm btn-neutral text-dark text-primary-hover bg-gray-300">
                  <i class="bi bi-person-circle text-warning"></i> View Profile
                </button>
              </router-link>

              <router-link :to="{ path: '/edit/' + user.id }">
                <button type="button" class="btn btn-sm btn-neutral text-white text-dark-hover bg-warning ml-2">
                  <i class="bi bi-pencil-square"></i> Edit
                </button>
              </router-link>

              <button type="button" class="btn btn-sm btn-neutral text-white text-dark-hover bg-danger ml-2"
                @click="deleteUser(user.id)">
                <i class="bi bi-trash-fill"></i> Delete
              </button>
            </td>
          </tr>
        </tbody>
          <tr v-else>
            <td colspan="6" class="text-center text-danger">
              This class does not have any students.
            </td>
          </tr> 
      </table>
      <div class="card-footer border-0 py-5">
        <span class="text-muted text-sm">   
          Total Students in class {{ selectedClass }} :
        {{ listUser?.length }} people</span>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import swal from "sweetalert";
import Swal from "sweetalert2";
import http from "../../htpp.common";
export default {
  data() {
    return {
      listUser: [],
      errorMessage: "",
      searchQuery: "",
      grades: [
        { label: "Grade 9A", value: "9A" },
        { label: "Grade 9B", value: "9B" },
        { label: "Grade 9C", value: "9C" },
        { label: "Grade 10A", value: "10A" },
        { label: "Grade 10B", value: "10B" },
        { label: "Grade 10C", value: "10C" },
        { label: "Grade 11A", value: "11A" },
        { label: "Grade 11B", value: "11B" },
        { label: "Grade 11C", value: "11C" },
        { label: "Grade 12A", value: "12A" },
        { label: "Grade 12B", value: "12B" },
        { label: "Grade 12C", value: "12C" },
      ],
      selectedClass: null,
      getClassURL:"http://127.0.0.1:8000/api/getuserInClass"
    };
  },

  computed: {
    filteredStudentsList() {
      if (this.searchQuery === "") {
        return this.listUser;
      } else {
        const filtered = this.listUser.filter((student) =>
          (student.first_name + " " + student.last_name)
            .toLowerCase()
            .includes(this.searchQuery.trim().toLowerCase())
        );
        if (filtered.length === 0) {
          return [
            {
              first_name: "Student not found",
              last_name: "",
              email: "",
              phone_number: "",
              etc: "",
            },
          ];
        } else {
          return filtered;
        }
      }
    },
  },
  methods: {
    //===================get data from Database =================
    getStudents() {
      http.get('/api/get-students')
      .then((response) => {
        this.listUser = response.data.data;
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
          axios
            .delete(this.URL + `/${id}`)
            .then(() => {
              swal("Deleted!", "Your user has been deleted.", "success");
              // call mounted
              this.getStudents();
            })
            .catch((error) => {
              swal(
                "Error",
                "An error occurred while deleting the user.",
                "error"
              );
              console.error(error);
            });
        } else {
          swal("Cancelled", "Your user is safe :)", "error");
        }
      });
    },

    importFile() {
      /// progressbar
      let timerInterval;
      Swal.fire({
        title: "File Uploading",
        html: "Please wait for file upload <b></b> %.",
        timer: 2000, // Change the timer to 5000ms (5 seconds)
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading();
          const b = Swal.getHtmlContainer().querySelector("b");
          let startTime = Date.now();
          timerInterval = setInterval(() => {
            let elapsedTime = Date.now() - startTime;
            let progress = Math.min(100, Math.round(elapsedTime / 20));
            b.textContent = progress;
          }, 20);
        },
        willClose: () => {
          clearInterval(timerInterval);
        },
      }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
          console.log("I was closed by the timer");
        }
      });
      /// data upload

      const file = this.$refs.fileInput.files[0];
      const formData = new FormData();
      formData.append("file", file);

      http
        .post("/api/users_import", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
            "Cache-Control": "no-cache",
          },
        })
        .then((response) => {
          console.log(response.data);

          /// progressbar
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener("mouseenter", Swal.stopTimer);
              toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
          });

          Toast.fire({
            icon: "success",
            title: "Upload successful",
          });

          // Reset the file input field
          this.$refs.fileInput.value = '';
          // call mounted
          this.getStudents();

        })
        .catch((error) => {
          console.error(error.response.data);
        });
    },
    getStudentInClass(classId) {
      axios
        .get(this.getClassURL + "/" + `${classId}`)
        .then((response) => {
          this.listUser = response.data.data;
          for (let user of this.listUser) {
            this.listUser = user.students;
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },

  mounted() {
    this.getStudentInClass();
    this.$refs.fileInput.addEventListener("change", this.importFile);
    return this.getStudents();
  },
};
</script>

<style scoped>
.card{
  margin-left: 20%;
  background: #000;
}
.input-file {
  position: relative;
  overflow: hidden;
  width: 180px;
  border: none;
  background-color: #3590df;
  border-radius: 3px;
  box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.input-file:hover {
  background-color: #1d6f42;
}

.input-file [type="file"] {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  cursor: pointer;
}

.input-file label {
  color: #f1f1f1;
  cursor: pointer;
  margin-top: 2px;
}

.input-file .bi {
  color: #e2d7d7;
}

.bi-brightness-low {
  color: yellow;
}

.bi-cloud-arrow-up {
  font-size: 20px;
  margin-top: 20px;
}

.card{
  padding: 20px;
}
</style>
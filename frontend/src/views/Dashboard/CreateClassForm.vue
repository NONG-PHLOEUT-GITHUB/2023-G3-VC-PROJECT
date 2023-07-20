<template>
  <section class="container-fluid px-4 py-4">
    <div class="card bg-gray-300">
      <div class="p-5 pb-1">
        <div>
          <h3 class="fs-19 fw-bold text-center">ADD NEW CLASS</h3>
        </div>
      </div>
      <form class="row g-3 card-body p-5 pt-4" @submit.prevent="addClass()">
        <div class="col-md-6">
          <label for="validationCustom01" class="form-label">Class name</label>
          <input
            type="text"
            v-model="class_name"
            class="form-control"
            id="validationCustom01"
          />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom01" class="form-label"
            >Please select class owner</label
          >
          <select
            class="form-select align-self-end"
            v-model="teacher"
            aria-label="Default select example"
            id="validationCustom01"
          >
            <option selected disabled>Select teacher</option>
            <option
              v-for="teacher in teachers"
              :value="teacher.id"
              :key="teacher.id"
            >
              {{ teacher.first_name }} {{ teacher.last_name }}
            </option>
          </select>
          <div class="valid-feedback">Looks good!</div>
        </div>

        <img v-bind:src="profilePreview" />
        <div class="col-12 d-flex justify-content-end">
          <router-link
            type="submit"
            class="btn btn-warning text-white mr-2"
            :to="{ path: '/class' }"
            >Cancel</router-link
          >
          <button type="submit" class="btn btn-primary text-white">
            Add Class
          </button>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import axios from "axios";
import swal from "sweetalert2";
export default {
  data() {
    return {
      profilePreview: null,
      class_name: "",
      teacher: "",
      URL: "http://127.0.0.1:8000/api/classes",
      TeacherURL:"http://127.0.0.1:8000/api/getTeachers",
      listClasses: [],
      teachers: [],
    };
  },
  methods: {
    addClass() {
      if (this.class_name && this.teacher) {
        const newClass = {
          class_name: this.class_name,
          teacher: this.teacher.first_name,
        };
        axios.post(this.URL, newClass).then((response) => {
          console.log(response.data);
          this.listClasses.push(response.data);
        });
        console.log(newClass);
        swal
          .fire({
            icon: "success",
            title: "create class successfully!",
            text: "you already created your class",
            timer: 2000,
          })
          .then(() => {
            this.$router.push({ path: "/class" });
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        swal.fire("Complete first", "complete all input", "info");
      }
    },
  },

  mounted() {
    axios
      .get(this.TeacherURL)
      .then((response) => {
        this.teachers = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>

<style scoped>
.gender {
  background: #f8f7f7;
  padding: 10px;
  border-radius: 5px;
}
img {
  width: 100px;
}
</style>
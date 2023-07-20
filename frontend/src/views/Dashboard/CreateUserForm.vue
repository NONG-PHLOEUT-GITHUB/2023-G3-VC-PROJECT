<template>
  <section class="container-fluid px-4 py-4 ">
    <div class="card bg-gray-300">
      <div class="p-5 pb-1">
        <div>
          <h3 class="fs-19 fw-bold text-center">CREATE USER</h3>
        </div>
      </div>
      <form class="row g-3 card-body p-5 pt-4 " @submit.prevent="addUserData()">
        <!-- firstname -->
        <div class="col-md-6">
          <label for="validationCustom01" class="form-label">First name</label>
          <input type="text" v-model="first_name" class="form-control" id="validationCustom01" />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Last name</label>
          <input type="text" v-model="last_name" class="form-control" id="validationCustom02" />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Email</label>
          <input type="text" v-model="email" class="form-control" id="validationCustom02" />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Password</label>
          <input type="text" v-model="password" class="form-control" id="validationCustom02" />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Phone Number</label>
          <input type="tel" v-model="phone_number" class="form-control" id="phoneNumber" placeholder="" />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Address</label>
          <input type="tel" class="form-control" v-model="address" id="addreess" placeholder="   " />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Date of Birth</label>
          <input type="date" class="form-control" :max="max_date" v-model="date_of_birth" id="dateOfBirth" placeholder="" />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col-md-6">
          <label for="validationCustom02" class="form-label">Age</label>
          <input type="number" class="form-control" id="dateOfBirth" v-model="age" placeholder="" />
          <div class="valid-feedback">Looks good!</div>
        </div>

        <div class="col-md-5">
          <label for="validationCustom02" class="form-label">Gender</label>
          <div class="gender">
            <input type="radio" name="gender" id="male" value="male" v-model="gender" class="form-check-input" />
            <label class="form-check-label" for="male">Male</label>
            <input type="radio" name="gender" id="female" value="female" v-model="gender" class="form-check-input ml-5" />
            <label class="form-check-label" for="female">Female</label>
          </div>
        </div>

        <div class="mb-3 col-md-2 ">
          <label for="formFileDisabled" class="form-label ml-5">Role</label> <br>
          <div class="dropdown bg-white rounded-1 ">
            <select class="form-select align-self-end" v-model="role" aria-label="Default select example"
              id="validationCustom01">
              <option selected disabled>Select user role</option>
              <option value="1">Director</option>
              <option value="2">Teacher</option>
              <option value="3">Student</option>
            </select>
          </div>
        </div>

        <div class="mb-3 col-md-5">
          <label for="formFileDisabled" class="form-label">Profile</label>
          <input class="form-control" type="file" id="formFileDisabled" @change="getImage">
        </div>

        <img v-bind:src="profilePreview">
        <div class="col-12 d-flex justify-content-end">
          <router-link type="submit" class="btn btn-warning text-white mr-2"
            :to="{ path: '/student' }">Cancel</router-link>
          <button type="submit" class="btn btn-primary text-white">Add User</button>
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
      first_name: "",
      last_name: "",
      email: "",
      password: "",
      phone_number: "",
      address: "",
      date_of_birth: "",
      age: "",
      gender: "",
      profile: "",
      role: "",
      URL: "http://127.0.0.1:8000/api/users",
      imgURL: "http://127.0.0.1:8000/api/getImage",
      listUser: []
    };
  },
  methods: {
    // resferent :  https://www.youtube.com/watch?v=chCtrNGrQhk
    getImage(event) {
      // this.profile = event.target.files[0];
      var file = event.target.files[0];
      var form = new FormData();
      form.append('profile', file);
      axios.post(this.imgURL, form).then((response) => {
        this.profile = response.data;
      });
    },
    addUserData() {
      if(this.first_name && this.last_name && this.email && this.password && this.phone_number && this.address && this.role){
        const newUser =
        {
          first_name: this.first_name,
          last_name: this.last_name,
          gender: this.gender,
          role: this.role,
          age: this.age,
          date_of_birth: this.date_of_birth,
          phone_number: this.phone_number,
          address: this.address,
          email: this.email,
          password: this.password,
          profile: this.profile
        };
        axios.post(this.URL, newUser).then((response) => {
          this.listUser.push(response.data);
        });
        swal.fire({
          icon: "success",
          title: "Save user successfully!",
          text: "you already save your user",
          timer: 2000,
        })
          .then(() => {
            if(this.role==3){
              this.$router.push({ path: '/student' });
            }else if(this.role==2){
              this.$router.push({ path: '/teacher' });
            }
          }).catch(error => {
            console.log(error)
          })
      } else {
        swal.fire(
          'Complete first',
          'complete all input',
          'info'
        )
      }
    },
  },


  computed: {
    max_date() {
      const today = new Date();
      const year = today.getFullYear() -10;
      const month = today.getMonth() + 1; // add 1 because getMonth() returns 0-based month index
      const day = today.getDate();
      return `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
    },
    calculateAge() {
      if (!this.date_of_birth) return null;
      const today = new Date();
      const birthDate = new Date(this.date_of_birth);
      let age = today.getFullYear() - birthDate.getFullYear();
      const monthDiff = today.getMonth() - birthDate.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      return age;
    },
  },
  watch: {
    date_of_birth: function () {
      this.age = this.calculateAge;
    },
  },
}

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
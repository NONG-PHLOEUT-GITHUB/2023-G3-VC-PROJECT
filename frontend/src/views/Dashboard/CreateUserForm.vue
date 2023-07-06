<template>
  <form class="row g-2 needs-validation container" novalidate @submit.prevent="createUser()">
    <div class="title">
      <h3>CREATE USER</h3>
    </div>
    <div class="col-md-6">
      <label for="validationCustom01" class="form-label">First name</label>
      <input type="text" v-model="first_name" class="form-control" id="validationCustom01" required />
      <div class="valid-feedback">Looks good!</div>
    </div>
    <div class="col-md-6">
      <label for="validationCustom02" class="form-label">Last name</label>
      <input type="text" v-model="last_name" class="form-control" id="validationCustom02" required />
      <div class="valid-feedback">Looks good!</div>
    </div>
    <div class="col-md-6">
      <label for="validationCustom02" class="form-label">Email</label>
      <input type="text" v-model="email" class="form-control" id="validationCustom02" required />
      <div class="valid-feedback">Looks good!</div>
    </div>
    <div class="col-md-6">
      <label for="validationCustom02" class="form-label">Password</label>
      <input type="text" v-model="password" class="form-control" id="validationCustom02" required />
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
      <input type="date" class="form-control" v-model="date_of_birth" id="dateOfBirth" placeholder="" />
      <div class="valid-feedback">Looks good!</div>
    </div>
    <div class="col-md-6">
      <label for="validationCustom02" class="form-label">Age</label>
      <input type="number" class="form-control" id="dateOfBirth" v-model="age" placeholder="" />
      <div class="valid-feedback">Looks good!</div>
    </div>

    <div class="col-md-4">
      <label for="validationCustom02" class="form-label">Gender</label>
      <div class="gender">
        <input type="radio" name="gender" id="male" value="male" v-model="gender" class="form-check-input" />
        <label class="form-check-label" for="male">Male</label>
        <input type="radio" name="gender" id="female" value="female" v-model="gender" class="form-check-input ml-5" />
        <label class="form-check-label" for="female">Female</label>
      </div>
    </div>
    <div class="col-md-4">
      <label for="validationCustom02" class="form-label">Profile</label>
      <input type="file" class="form-control-file" id="fileInput" @change="getFile" placeholder="Choose File" />
      <div class="valid-feedback">Looks good!</div>
    </div>

    <!-- <div class="col-md-4">
      <label for="validationCustom02" class="form-label">Role</label>
      <select class="form-select" required aria-label="select example" v-model="role">
        <option selected>Choose role</option>
        <option value="director">Director</option>
        <option value="teacher">Teacher</option>
        <option value="student">Student</option>
      </select>
      <div class="invalid-feedback">Example invalid select feedback</div>
    </div> -->

    <div class="col-12">
      <div class="form-check">
        <div class="invalid-feedback">You must agree before submitting.</div>
      </div>
    </div>
    <div class="col-8 mx-auto">
      <button class="btn btn-primary mx-auto fw-bold" type="submit">
        ADD USER
      </button>
    </div>
    `
  </form>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      first_name: "",
      last_name: "",
      email: "",
      password: "",
      phone_number: "",
      address: "",
      date_of_birth: "",
      age: "",
      profile: null,
      gender: "",
      //   role: "",
      URL: "http://127.0.0.1:8000/api/users",
    };
  },

  methods: {
    getFile(event) {
      this.profile = event.target.files[0]
    },
    createUser() {

      const newUser =
      {
        first_name: this.first_name,
        last_name: this.last_name,
        gender: this.gender,
        age: this.age,
        date_of_birth: this.date_of_birth,
        phone_number: this.phone_number,
        address: this.address,
        profile: this.profile.name,
        email: this.email,
        password: this.password,
      };
      const files = new FormData();
      files.append('image', this.profile.name);
      // files.append('formData', JSON.stringify(newUser))
      axios.post(this.URL, newUser).then((response) => {
        console.log(response);
      });
    },

    // ===================get data from Database =================
    // getURL() {
    //   axios.get(this.URL).then((response) => {
    //     this.listUser = response.data.data;
    //     console.log(this.listUser);
    //   });
    // },
  },
  //   mounted() {
  //     return this.getURL();
  //   },

}
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Roboto&display=swap");

.container {
  font-family: "Roboto", sans-serif;
  margin: auto;
  margin-top: 30px;
  padding: 20px;
  width: 50%;
  border-radius: 10px;
  box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px,
    rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px,
    rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
}

h3 {
  color: rgb(21, 26, 27);
  font-weight: bold;
  text-align: center;
}

button {
  width: 100%;
}
</style>

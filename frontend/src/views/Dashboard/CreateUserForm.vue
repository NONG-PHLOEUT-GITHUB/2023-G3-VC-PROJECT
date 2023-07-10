<template>
  <section class="container-fluid px-4 py-4 ">
        <div class="card bg-gray-300">
            <div class="p-5 pb-1">
                <div>
                    <h3 class="fs-19 fw-bold text-center">CREATE USER</h3>
                </div>
            </div>
            <form class="row g-3 card-body p-5 pt-4 " @submit.prevent="createUser()">
              <!-- firstname -->
              <div class="col-md-6">
                <label for="validationCustom01" class="form-label">First name</label>
                <input type="text" v-model="first_name" class="form-control" id="validationCustom01"  />
                <div class="valid-feedback">Looks good!</div>
              </div>
              <div class="col-md-6">
                <label for="validationCustom02" class="form-label">Last name</label>
                <input type="text" v-model="last_name" class="form-control" id="validationCustom02"  />
                <div class="valid-feedback">Looks good!</div>
              </div>
              <div class="col-md-6">
                <label for="validationCustom02" class="form-label">Email</label>
                <input type="text" v-model="email" class="form-control" id="validationCustom02"  />
                <div class="valid-feedback">Looks good!</div>
              </div>
              <div class="col-md-6">
                <label for="validationCustom02" class="form-label">Password</label>
                <input type="text" v-model="password" class="form-control" id="validationCustom02"  />
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

              <div class="col-md-6">
                <label for="validationCustom02" class="form-label">Gender</label>
                <div class="gender">
                  <input type="radio" name="gender" id="male" value="male" v-model="gender" class="form-check-input" />
                  <label class="form-check-label" for="male">Male</label>
                  <input type="radio" name="gender" id="female" value="female" v-model="gender" class="form-check-input ml-5" />
                  <label class="form-check-label" for="female">Female</label>
                </div>
              </div>
            
              <div class="mb-3 col-md-6">
                <label for="formFileDisabled" class="form-label">Profile</label>
                <input class="form-control" type="file" id="formFileDisabled" @change="getFile" >
              </div>
              <img v-bind:src="profilePreview" >
              <div class="col-12 d-flex justify-content-end">
                <router-link type="submit" class="btn btn-warning text-white mr-2" :to="{ path: '/student'}">Cancel</router-link>
                <button type="submit" class="btn btn-primary text-white"  >Add User</button>
              </div>
            </form>
        </div>
    </section>
</template>

<script>
import axios from "axios";
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
      profile: "",
      gender: "",
      URL: "http://127.0.0.1:8000/api/users",
      listUser:[]
    };
  },
  methods: {
    getFile(event) {
      this.profile = event.target.files[0];
      const reader = new FileReader();
      reader.addEventListener("load", function() {
        this.profilePreview = reader.result;
      }
      .bind(this), false);
      if(this.profile){
        if( /\.(jpe?g|png|gif|jpg)$/i.test(this.profile.name)){
          reader.readAsDataURL(this.profile);
          // console.log(reader.readAsDataURL(this.profile));
        }
      }
    },
    createUser() {
      // if(this.first_name && this.last_name && this.email && this.password && this.phone_number && this.address){
        const newUser =
        {
          first_name: this.first_name,
          last_name: this.last_name,
          gender: this.gender,
          age: this.age,
          date_of_birth: this.date_of_birth,
          phone_number: this.phone_number,
          address: this.address,
          profile:this.profile.name,
          email: this.email,
          password: this.password,
        };
        axios.post(this.URL, newUser).then((response) => {
          this.listUser.push(response.data);
          console.log(this.listUser);
        });
      // }
    },
  }
  }

</script>

<style scoped>
  .gender{
    background: #f8f7f7;
    padding: 10px;
    border-radius: 5px;
  }
  img{
    width: 100px;
  }
</style>
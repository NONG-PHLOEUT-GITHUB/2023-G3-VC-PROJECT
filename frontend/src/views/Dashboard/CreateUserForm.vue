<template>
  <section class="container-fluid px-4 py-4">
    <div class="card bg-gray-300">
      <div class="p-5 pb-1">
        <div>
          <h3 class="fs-19 fw-bold text-center">CREATE USER</h3>
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
      listUser:[]
    };
  },
  methods: {
    getImage(event) {
      // this.profile = event.target.files[0];
      var file = event.target.files[0]; 
      var form = new FormData();
      form.append('profile', file);
      axios.post(this.imgURL, form).then((response) => 
      {
        this.profile =response.data;
      });
    },
    addUserData() {
      if(this.first_name && this.last_name && this.email && this.password && this.phone_number && this.address){
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
        axios.post( this.URL , newUser).then((response) => {
          this.listUser.push(response.data);
        });
        swal.fire({
          icon: "success",
          title: "Save attendance successfully!",
          text: "you already save your attendance",
          timer: 2000,
        })
        .then(() => {
            this.$router.push({ path: '/student' });
        }).catch(error=>{
          console.log(error)
        })
      }else{
        swal.fire(
        'Complete first',
        'complete all input',
        'info'
      )  
      }
    },
  },

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
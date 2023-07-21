<template>
  <section>
    <div class="container py-5">
      <div class="row">
        <div class="col-lg-4">
          <div class="card mb-4">
            <div class="card-body text-center">
              <div class="profile">
                <img :src="users.profile" alt="Avatar" class="img-fluid my-7 w-75 rounded-circle" />
              </div>
              <h5 class="my-3">{{ users.first_name }} {{ users.last_name }}</h5>
              <h3 class="mb-2">Class 11A</h3>
              <div class="d-flex justify-content-center mb-2">
                <button type="button" class="btn btn-primary text-white">Edit profile</button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card mb-4">
            <div class="card-body">
              <div class="card-title">
                <h3 class="text-primary">Personal Information</h3>
              </div>

              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0"><i class="bi bi-person me-4"></i>Full Name</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">
                    {{ users.first_name }} {{ users.last_name }}
                  </p>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">

                  <p class="mb-0"><i class="bi bi-person-check me-4"></i>Gender</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{ users.gender }}</p>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0"><i class="bi bi-calendar-date me-4"></i>Age</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{ users.age }}</p>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0"><i class="bi bi-calendar-check me-4"></i>Date Of Birth</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{ users.date_of_birth }}</p>
                </div>
              </div>
              <hr />
              <div class="card-title">
                <h3 class="text-primary">Contact Information</h3>
              </div>

              <div class="row">

                <div class="col-sm-3">
                  <p class="mb-0 "><i class="bi bi-telephone me-4"></i>PhoneNumber</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{ users.phone_number }}</p>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0"><i class="bi bi-envelope me-4"></i>Email</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{ users.email }}</p>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0"><i class="bi bi-geo-alt me-4"></i>Address</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{ users.address }}</p>
                </div>
              </div>
              <hr />
              <div class="card-title">
                <h3 class="text-primary">Parent Information</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import http from "../../htpp.common";

export default {
  name: "UserDetails",
  data() {
    return {
      users: " ",
    };
  },
  methods: {
    fetchData() {
      http.get("/api/v1/auth/user").then((response) => {
        this.users = response.data.data;
        console.log(response.data.data);
      });
    },
  },

  mounted() {
    this.fetchData();
  },
};
</script>


<style scoped>
@import url(https://unpkg.com/@webpixels/css@1.1.5/dist/index.css);

/* Bootstrap Icons */
@import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");

.my-3 {
  text-transform: uppercase;
  font-size: 25px;
}


.profile {
    position: relative;
  }
  
  .profile img {
    border: solid 1px rgb(11, 152, 187);
    width: 250px;
    height: 250px;
    border-radius: 50%;
    object-fit: cover;
    cursor: pointer;
}
</style>
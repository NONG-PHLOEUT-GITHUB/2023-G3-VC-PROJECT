<!-- <template>
    <section style="background-color: #eee;">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
                                alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3">{{ users.first_name }} {{ users.last_name }}</h5>
                            <p class="text-muted mb-1">Full Stack Developer</p>
                            <p class="text-muted mb-4">Bay Area, San Francisco, CA</p>
                            <div class="d-flex justify-content-center mb-2">
                                <button type="button" class="btn btn-primary">Follow</button>
                                <button type="button" class="btn btn-outline-primary ms-1">Message</button>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush rounded-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fas fa-globe fa-lg text-warning"></i>
                                    <p class="mb-0">https://mdbootstrap.com</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-github fa-lg" style="color: #333333;"></i>
                                    <p class="mb-0">mdbootstrap</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-twitter fa-lg" style="color: #55acee;"></i>
                                    <p class="mb-0">@mdbootstrap</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                                    <p class="mb-0">mdbootstrap</p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                                    <p class="mb-0">mdbootstrap</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div  class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Full Name </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ users.first_name }} {{ users.last_name }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Gender</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ users.gender }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Age</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ users.age }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Date Of Birth</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ users.date_of_birth }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">PhoneNumber</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ users.phone_number }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Address</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ users.address }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ users.email }}</p>
                                </div>
                            </div>
                            <hr>
                            <hr>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4 mb-md-0">
                                <div class="card-body">
                                    <p class="mb-4"><span class="text-primary font-italic me-1">assigment</span> Project
                                        Status
                                    </p>
                                    <p class="mb-1" style="font-size: .77rem;">Web Design</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Website Markup</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 72%" aria-valuenow="72"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">One Page</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 89%" aria-valuenow="89"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Mobile Template</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="55"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Backend API</p>
                                    <div class="progress rounded mb-2" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 66%" aria-valuenow="66"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-4 mb-md-0">
                                <div class="card-body">
                                    <p class="mb-4"><span class="text-primary font-italic me-1">assigment</span> Project
                                        Status
                                    </p>
                                    <p class="mb-1" style="font-size: .77rem;">Web Design</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Website Markup</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 72%" aria-valuenow="72"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">One Page</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 89%" aria-valuenow="89"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Mobile Template</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="55"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Backend API</p>
                                    <div class="progress rounded mb-2" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 66%" aria-valuenow="66"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>

import http from '../../htpp.common'

export default ({
    name: "UserDetails",
    data() {
        return {
            users:" ",
        };
    },
    methods: {
        fetchData() {
            http.get('/api/v1/auth/user')
                .then(response => {
                    this.users = response.data.data;
                    console.log(response.data.data);
                });
        },
    },

    mounted(){
        this.fetchData();
    }




})
</script> -->

<!-- <template>
<div class="container ">
  <div class="col">
    <div class="row">
      <div class="col mb-3">
        <div class="card">
          <div class="card-body shadow-lg p-3 mb-5 bg-body rounded">
            <div class="e-profile">
              <div class="row">
                <div class="col-12 col-sm-auto mb-3">
                  <div class="mx-auto" style="width: 140px;">
                    <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                      <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">140x140</span>
                    </div>
                  </div>
                </div>
                <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                  <div class="text-center text-sm-left mb-2 mb-sm-0">
                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">John Smith</h4>
                    <p class="mb-0">@johnny.s</p>
                    <div class="text-muted"><small>Last seen 2 hours ago</small></div>
                    <div class="mt-2">
                      <button class="btn btn-primary" type="button">
                        <i class="fa fa-fw fa-camera"></i>
                        <span>Change Photo</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template> -->

<template>
  <section>
    <div class="card mb-3 bg-gray-300">
      <div class="row">
        <div
          class="col-md-3 gradient-custom text-center text-white align-items-center"
          style="
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
          "
        >
          <img
            :src="users.profile"
            alt="Avatar"
            class="img-fluid my-7"
            style="width: 150px; border-radius: 50%;"
          />
          <h3 class="text-warning">
            {{ users.first_name + " " + users.last_name }}
          </h3>
          <p class="text-dark">Class 12A</p>
        </div>

        <div class="col-md-9">
          <div class="card-body">
            <h4 class="text-primary">Personal Information</h4>
            <hr class="mt-1 mb-4" />
            <div class="row pt-1">
              <div class="col-4 mb-2">
                <h6 class="text-muted">First Name</h6>
                <p class="text-dark">{{ users.first_name }}</p>
              </div>
              <div class="col-4 mb-2">
                <h6 class="text-muted">Last Name</h6>
                <p class="text-dark">{{ users.last_name }}</p>
              </div>
              <div class="col-4 mb-2">
                <h6 class="text-muted">Gender</h6>
                <p class="text-dark">{{ users.gender }}</p>
              </div>
              <div class="col-4 mb-2">
                <h6 class="text-muted">Role</h6>
                <p class="text-dark" v-if="users.role == 3">student</p>
                <p class="text-dark" v-if="users.role == 2">teacher</p>
                <p class="text-dark" v-if="users.role == 1">director</p>
              </div>
              <div class="col-4 mb-2">
                <h6 class="text-muted">Age</h6>
                <p class="text-dark">{{ users.age }} years old</p>
              </div>
              <div class="col-4 mb-2">
                <h6 class="text-muted">Date of birth</h6>
                <p class="text-dark">{{ users.date_of_birth }}</p>
              </div>
            </div>
            <h4 class="text-primary">Contact Information</h4>
            <hr class="mt-1 mb-4" />
            <div class="row pt-1">
              <div class="col-4 mb-2">
                <h6 class="text-muted">Phone</h6>
                <p class="text-dark">{{ users.phone_number }}</p>
              </div>
              <div class="col-4 mb-2">
                <h6 class="text-muted">Email</h6>
                <p class="text-dark">{{ users.email }}</p>
              </div>
              <div class="col-4 mb-2">
                <h6 class="text-muted">Address</h6>
                <p class="text-dark">{{ users.address }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">

      <div class="col-sm-4">
        <div class="card bg-gray-300">
          <div class="card-body">
            <h4 class="card-title m-0">My Score list Reports</h4>
            <!-- <p class="card-text small mt-2 text-justify">
              As a student, keeping track of your score reports is crucial for your academic success. Score reports provide a record of your performance on assignments.
            </p> -->
            <router-link :to="{ path: '/monthly_report' }">
              <button type="button" class="btn btn-sm btn-neutral text-light text-dark-hover bg-primary mt-2">
                View Details
              </button>
            </router-link>
          </div>
        </div>
      </div>
      
      <div class="col-sm-4">
        <div class="card bg-gray-300">
          <div class="card-body">
            <h4 class="card-title m-0">My Score list Reports</h4>
            <!-- <p class="card-text small mt-2 text-justify">
              As a student, keeping track of your score reports is crucial for your academic success. Score reports provide a record of your performance on assignments.
            </p> -->
            <router-link :to="{ path: '/monthly_report' }">
              <button type="button" class="btn btn-sm btn-neutral text-light text-dark-hover bg-primary mt-2">
                View Details
              </button>
            </router-link>
          </div>
        </div>
      </div>

      <div class="col-sm-4">
        <div class="card bg-gray-300">
          <div class="card-body">
            <h4 class="card-title m-0">My Attendance Reports</h4>
            <!-- <p class="card-text small mt-2 text-justify">
              As a student, keeping track of your attendance reports is essential for your academic success that provide a record of your attendance in each class/subject.
            </p> -->
            <router-link :to="{ path: '/monthly_report' }">
              <button type="button" class="btn btn-sm btn-neutral text-light text-dark-hover bg-primary mt-2">
                View Details
              </button>
            </router-link>
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
      users: "",
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

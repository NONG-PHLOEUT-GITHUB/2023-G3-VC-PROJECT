<template>
<<<<<<< HEAD
  <div class="card shadow border-0 mb-7">
    <div class="card-header">
      <h3 class="mb-0 text-primary">STUDENTS LIST</h3>
    </div>
    <div class="card-header">
      <select v-model="selectedGrade" class="form-select mb-3" aria-label="Default select example" style="width: 30%;">
        <option selected disabled>Select grade</option>
        <option value="10">Grade 10</option>
        <option value="11">Grade 11</option>
        <option value="12">Grade 12</option>
      </select>
      <div class="form-group d-flex justify-content-between mb-3" style="width: 100%;">
        <form class="form-inline my-2 my-lg-0 d-flex" style="width: 60%;">
          <input class="form-control mr-sm-2" type="search" placeholder="Search student" aria-label="Search" style="width: 78%;" v-model="searchQuery">
          <button class="btn btn-outline-warning my-2 my-sm-0 " type="button" ><i class="bi bi-search"></i> Search</button>
        </form>
        <router-link :to="{ path: '/createUser' }" class="text-white" style="width: 20%;">
          <button type="button" class="btn btn-primary align-self-end" style="width: 100%;">
            <i class="bi bi-person-plus-fill"></i> Add new student
          </button>
        </router-link>
      </div>
    </div>
    <!-- get data form database to display -->
    
    <div class="table-responsive" >
      <div class="card-header">
        <h5 class="mb-0 p-0 text-primary">STUDENT LIST CLASS {{selectedClass}}</h5>
      </div>
      <table class="table table-hover table-nowrap">
        <thead class="thead-light">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Gender</th>
            <th scope="col">Age</th>
            <th scope="col">Email</th>
            <th scope="col">Phone Number</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, id) of filteredStudentsList" :key="id" class="border-2-dark">
            <td>
              <img alt="" src="https://play-lh.googleusercontent.com/pjPN53lzZhnsxtS7IaxxT8WndB6Imi8JjD1P7xLSJnnbCKyDPHRyvvy30KsGH-0mmQ" class="avatar avatar-sm rounded-circle me-2">
              <a class="text-heading font-semibold" href="#">
                {{user.first_name}} {{user.last_name}} 
              </a>
            </td>
            <td>
              {{user.gender}}
            </td>
            <td>
              {{user.age}}
            </td>
            <td>
              {{user.email}}
            </td>
            <td>
              {{user.phone_number}}
            </td>
            <td class="text-end d-flex justify-content-end">
                <router-link  :to="{ path: '/student_detail/' + user.id }">
                    <button type="button" class="btn btn-sm btn-neutral text-dark text-primary-hover">
                     <i class="bi bi-person-circle"></i> View Profile
                    </button>
                </router-link>           
              <router-link :to="{ path: '/edit/' + user.id }">
                <button type="button" class="btn btn-sm btn-neutral text-white text-dark-hover bg-warning ml-2">
                  <i class="bi bi-pencil-square"></i> Edit
                </button>
              </router-link>
              <button type="button" class="btn btn-sm btn-neutral text-white text-dark-hover bg-danger ml-2" @click="deleteUser(user.id)">
                <i class="bi bi-trash-fill"></i> Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
=======
    <div class="card shadow border-0 mb-7">
        <div class="card-header">
            <h3 class="mb-0 text-primary">STUDENTS LIST</h3>
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
                    <input class="form-control mr-sm-2" type="search" placeholder="Search student" aria-label="Search" style="width: 78%;">
                    <button class="btn btn-outline-warning my-2 my-sm-0 " type="button"><i class="bi bi-search"></i> Search</button>
                </form>
                <!-- <i class="bi bi-filetype-xlsx"></i> -->
                <button class="btn btn-primary">Import Excel file<i class="bi bi-file-earmark-arrow-down ms-4"></i></button>
                <router-link :to="{ path: '/createUser' }" class="text-white" style="width: 20%;"><button type="button" class="btn btn-primary align-self-end" style="width: 100%;"><i class="bi bi-person-plus-fill"></i> Add new student</button></router-link>
            </div>
        </div>
        <!-- get data form database to display -->
        <div class="card-header">
            <h5 class="mb-0 p-0 text-primary">STUDENT LIST CLASS 12A</h5>
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
                <tbody>
                    <tr v-for="(user, id) of listUser" :key="id" class="border-2-dark">
                        <td>
                            <img v-if="user.profile" alt=""
                            :src="user.profile"
                            class="avatar avatar-sm rounded-circle me-2">
                            <img v-else src="https://cdn-icons-png.flaticon.com/512/3177/3177440.png" alt="" class="avatar avatar-sm rounded-circle me-2">
                            <a class="text-heading font-semibold" href="#">
                                {{user.first_name}} {{user.last_name}} 
                            </a>
                        </td>
                        <td>
                            {{user.gender}}
                        </td>
                        <td>
                            {{user.age}}
                        </td>
                        <td>
                            {{user.email}}
                        </td>
                        <td>
                            {{user.phone_number}}
                        </td>
                        <td class="text-end d-flex justify-content-end">
                            <router-link :to="{ path: '/student_detail/' + user.id }">
                                <button type="button" class="btn btn-sm btn-neutral text-dark text-primary-hover bg-gray-300">
                                    <i  class="bi bi-person-circle text-warning" ></i> View Profile
                                </button>
                            </router-link>           
                            
                            <router-link  :to="{ path: '/edit/' + user.id }" >
                                <button type="button" class="btn btn-sm btn-neutral text-white text-dark-hover bg-warning ml-2">
                                    <i  class="bi bi-pencil-square" ></i> Edit
                                </button>
                            </router-link>
                                   
                       
                            <button type="button" class="btn btn-sm btn-neutral text-white text-dark-hover bg-danger ml-2" @click="deleteUser(user.id)">
                                <i class="bi bi-trash-fill"></i> Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>
>>>>>>> fe7abb50c575c377537c681cca9320aed136b624
</template>
<script>
import axios from "axios";
import swal from "sweetalert";
export default {
  props: {
    selectedClass: String,
    },
    data() {
      
        
        return {
            URL: "http://127.0.0.1:8000/api/users",
            listUser:[],
            errorMessage:"",
            searchQuery: "",
        }
    },

    computed: {
      filteredStudentsList() {
          if (this.searchQuery === "") {
              return this.listUser;
          } else {
              const filtered = this.listUser.filter(student =>
              (student.first_name + ' ' + student.last_name).toLowerCase().includes(this.searchQuery.trim().toLowerCase())
              );
              if (filtered.length === 0) {
                  return [{ first_name: "Student not found", last_name: "", email: "", phone_number: "", etc: "" }];
              } else {
              return filtered;
              }
          }
      },
    },
    methods:{
        //===================get data from Database =================
        getURL() {
            axios.get(this.URL).then((response) => {
                this.listUser = response.data.data;
                console.log(this.listUser);
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
                    this.getURL();
                    })
                    .catch(error => {
                    swal("Error", "An error occurred while deleting the user.", "error");
                    console.error(error);
                    });
                } else {
                swal("Cancelled", "Your user is safe :)", "error");
                }
            });
        }
  },
    mounted() {
        return this.getURL();
  }, 
  
    
}
</script>
<template>
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
                <router-link :to="{ path: '/createUser' }" class="text-white" style="width: 20%;"><button type="button" class="btn btn-primary align-self-end" style="width: 100%;"><i class="bi bi-person-plus-fill"></i> Add new student</button></router-link>
            </div>
        </div>
        <!-- get data form database to display -->
        <div class="card-header">
            <h5 class="mb-0 p-0 text-primary">STUDENT LIST CLASS 12A</h5>
        </div>
        <div class="table-responsive">
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
                    <!-- <tr v-for="student of studentsList" :key="student" class="border-2-dark"> -->
                    <tr v-for="(user, id) of listUser" :key="id" class="border-2-dark">
                        <td>
                            <img alt="..."
                                src="{{ user.profile }}"
                                class="avatar avatar-sm rounded-circle me-2">
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
                            <button type="button" class="btn btn-sm btn-neutral  text-dark text-primary-hover">
                                <i class="bi bi-person-circle"></i> View Profile
                            </button>
                            <router-link  :to="{ path: '/createUser' }"><button type="button" class="btn btn-sm btn-neutral text-white text-dark-hover bg-warning ml-2" @click="editUser(id)">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button></router-link>
                            <button type="button" class="btn btn-sm btn-neutral text-white text-dark-hover bg-danger ml-2" @click="deleteUser(user.id)">
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
export default {
    data() {
        
        return {
            // studentsList: [
            //     {name: "Rien Leam", gender: "Male", age: 19, class: "12A", phone: "0977348624"},
            //     {name: "Rien Leam", gender: "Male", age: 19, class: "12A", phone: "0977348624"},
            //     {name: "Rien Leam", gender: "Male", age: 19, class: "12A", phone: "0977348624"},
            //     {name: "Rien Leam", gender: "Male", age: 19, class: "12A", phone: "0977348624"},
            //     {name: "Rien Leam", gender: "Male", age: 19, class: "12A", phone: "0977348624"},
            //     {name: "Rien Leam", gender: "Male", age: 19, class: "12A", phone: "0977348624"},
            //     {name: "Rien Leam", gender: "Male", age: 19, class: "12A", phone: "0977348624"},
            //     {name: "Rien Leam", gender: "Male", age: 19, class: "12A", phone: "0977348624"},
            // ]
            URL: "http://127.0.0.1:8000/api/users",
            listUser:[]
        }
    },
    methods:{
        //===================get data from Database =================
        getURL() {
            axios.get(this.URL).then((response) => {
                this.listUser = response.data.data;
                console.log(this.listUser);
            });
        }, 
        // ================== Edit a user ==================
        // deleteUser(id) {
        //     axios.put(this.URL + `/${id}`)
        //     .then(() => {
        //         this.getURL();
        //     })
        //     .catch(error => {
        //         console.error(error);
        //     });
        // },
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
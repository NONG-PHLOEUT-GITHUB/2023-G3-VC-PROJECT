<template>
    <section style="background-color: #eee;">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">User</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center" >
                            <img 
                                :src="responseData.profile"
                                  class="rounded-circle img-fluid " >
                               
                            <!-- <div class="user-profile">
                                <img v-if="this.profileUser != '' " :src="userProfilePreview"
                                  class="rounded-circle img-fluid image-pf" >
                                <img v-else src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQEczTcVOGPs9JFtQTR0VwzAT7jOxyKUmXmJVTnozJGqsQgx73NeFsHBXezaGWsq4xNW6E&usqp=CAU"
                                  class="rounded-circle img-fluid image-pf" >
                                <input type="file" class="img-detail" @change="getFile">
                            </div> -->
                            
                            <h5 class="my-3" >{{responseData.first_name}} {{responseData.last_name}}</h5>
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
                        <div class="card-body">
                            <div class="row" >
                                <div class="col-sm-3">
                                    <p class="mb-0">Name </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{responseData.first_name}} {{responseData.last_name}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row" >
                                <div class="col-sm-3">
                                    <p class="mb-0">Gender</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{responseData.gender}}</p>
                                </div>
                            </div>
                            <hr>
                             <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Age</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{responseData.age}}</p>
                                </div>
                            </div>
                            <hr>
                             <div class="row" >
                                <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{responseData.email}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">PhoneNumber</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{responseData.phone_number}}</p>
                                </div>
                            </div>
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
import axios from 'axios';

export default {
    name: "App",
    data() {
        return {
        responseData: [],
        userProfilePreview : null,
        profileUser : '',
        };
    },
    methods: {
        fetchDataById(id) {
        axios.get(`http://localhost:8000/api/users/${id}`)
            .then(response => {
            this.responseData = response.data.data;
            console.log(this.responseData);
            })
            .catch(error => {
            console.error(error);
            });
        },
        // upload image 
        getFile(event) {
        this.profileUser = event.target.files[0];
        const reader = new FileReader();
        reader.addEventListener("load", function() {
            this.userProfilePreview = reader.result;
        }
        .bind(this), false);
        if(this.profileUser){
            if( /\.(jpe?g|png|gif|jpg)$/i.test(this.profileUser.name)){
            reader.readAsDataURL(this.profileUser);
            }
        }
        },
    },
    mounted(){
        const id = this.$route.params.id;
        console.log(id);
        this.fetchDataById(id);
    }
};
</script>
<style scoped>
    .image-pf{
        position: relative;
        height: 150px;
        width: 150px;
        border-radius: 50%;
        margin: auto;
        overflow: hidden;

    }
    .img-detail{
        position: absolute;
        outline: none;
        color: transparent;
        margin: 100px 100px 0 -86px;
        transition: 0.5s;
        cursor: pointer;
        box-sizing: border-box;
        opacity: 0;
        
    }
    .img-detail::-webkit-file-upload-button{
        visibility: hidden;
    }
    .img-detail::before{
        content: '\f030';
        font-family: fontAwesome;
        font-size: 20px;
        color: rgba(255, 255, 255, 0.966);
    }
    
    .img-detail:hover{
        opacity: 1;
    }
    
    
</style>

<template>
    <!-- Dashboard -->
    <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
        <!-- Vertical Navbar -->
        <nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light border-bottom border-bottom-lg-0 border-end-lg bg-gray-300"
            id="navbarVertical">
            <div class="container-fluid" id="sidebarCollapse">
                <!-- Toggler -->
                <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse"
                    data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Brand -->
                <a class="navbar-brand py-lg-2 mb-lg-5 px-lg-6 me-0" href="#">
                    <!-- <img src="https://cdn-icons-png.flaticon.com/512/855/855601.png"  alt="..."> -->
                    <h3 class="text-dark text-center"><b>PRINAVISCHOOL</b></h3>
                </a>
                <!-- Collapse -->
                <div class="collapse navbar-collapse">
                    <!-- Navigation -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link class="nav-link text-primary" href="#" :to="{ path: '/home' }"
                                :class="{ active: $route.path === '/home' }">
                                <i class="bi bi-house my-icon"></i> Dashboard
                            </router-link>

                            <!-- //teacher management -->

                            <a @click="toggleLinks('teacher')" class="nav-link text-primary">
                                <i class="bi bi-person my-icon"></i> Teacher management
                                <i class="bi bi-sort-down my-icon ms-4"></i>
                            </a>
                            <router-link v-show="isLinkActiveTeacher" class="nav-link text-primary ms-4" href="#"
                                :to="{ path: '/teacher_list' }" :class="{ 'active': $route.path === '/teacher_list' }">
                                <i class="bi bi-list my-icon"></i> Teacher List
                            </router-link>
                            <router-link v-show="isLinkActiveTeacher" class="nav-link text-primary ms-4" href="#"
                                :to="{ path: '/teacher' }" :class="{ 'active': $route.path === '/teacher' }">
                                <i class="bi bi-gear my-icon"></i>Add Teacher
                            </router-link>
                        </li>

                        <!-- //student management -->

                        <li class="nav-item">
                            <a @click="toggleLinks('student')" class="nav-link text-primary">
                                <i class="bi bi-people my-icon"></i> Student management
                                <i class="bi bi-sort-down my-icon ms-4"></i>
                            </a>
                            <router-link v-show="isLinkActiveStudent" class="nav-link text-primary ms-4" href="#"
                                :to="{ path: '/student_list' }" :class="{ active: $route.path === '/student_list' }">
                                <i class="bi bi-list my-icon"></i> Student List
                            </router-link>
                            <router-link v-show="isLinkActiveStudent" class="nav-link text-primary ms-4" href="#"
                                :to="{ path: '/student' }" :class="{ active: $route.path === '/student' }">
                                <i class="bi bi-gear my-icon"></i>Add student Student
                            </router-link>
                        </li>

                        <!-- class management -->

                        <li class="nav-item">
                            <a @click="toggleLinks('class')" class="nav-link text-primary" href="#" >
                                <i class="bi bi-building my-icon"></i> Class management
                            </a>
                            <router-link v-show="isLinkActiveClass" class="nav-link text-primary ms-4" href="#"
                                :to="{ path: '/class_list' }" :class="{ active: $route.path === '/class_list' }">
                                <i class="bi bi-gear my-icon"></i>Class list
                            </router-link>
                            <router-link v-show="isLinkActiveClass" class="nav-link text-primary ms-4" href="#"
                                :to="{ path: '/class_owner' }" :class="{ active: $route.path === '/class_owner' }">
                                <i class="bi bi-gear my-icon"></i>Class owner
                            </router-link>
                        </li>

                        <!-- //attendance management -->

                        <li  class="nav-item">
                            <a @click="toggleLinks('attendance')" class="nav-link text-primary" href="#" :to="{ path: '/attendance' }"
                                :class="{ active: $route.path === '/attendance' }">
                                <i class="bi bi-clipboard-check my-icon"></i>Attendance management
                                
                            </a>
                            <router-link v-show="isLinkActiveAttendance" class="nav-link text-primary ms-4" href="#"
                                :to="{ path: '/attendance_list' }" :class="{ active: $route.path === '/attendance_list' }">
                                <i class="bi bi-check2-circle my-icon"></i>Student Attendance
                            </router-link>
                        </li>

                        <!-- //score management -->

                        <li class="nav-item">
                            <a @click="toggleLinks('score')" class="nav-link text-primary" href="#" :to="{ path: '/score' }"
                                :class="{ active: $route.path === '/score' }">
                                <i class="bi bi-files-alt my-icon"></i> Score management
                            </a>
                            <router-link v-show="isLinkActiveScore" class="nav-link text-primary ms-4" href="#"
                                :to="{ path: '/2' }" :class="{ active: $route.path === '/2' }">
                                <i class="bi bi-clipboard-check my-icon"></i> Student Score
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link class="nav-link text-primary" href="#" :to="{ path: '/schedule' }"
                                :class="{ active: $route.path === '/schedule' }">
                                <i class="bi bi-table"></i> Schedule
                            </router-link>
                        </li>
                    </ul>
                    <!-- Divider -->
                    <hr class="navbar-divider my-5 opacity-20" />
                    <div class="mt-auto"></div>
                </div>
            </div>
        </nav>
        <div class="h-screen flex-grow-1 overflow-y-lg-auto">
            <!-- Header -->
            <header class="bg-surface-primary border-bottom pt-6 sticky-top">
                <div class="container-fluid mt-3">
                    <div class="mb-npx mb-7">
                        <div class="row align-items-center">
                            <div class="col-sm-6 col-12 mb-4 mb-sm-0">
                                <!-- Title -->
                                <h1 class="h2 mb-0 ls-tight">SCHOOL MANAGEMENT</h1>
                            </div>
                            <!-- profile -->
                            <div class="col-sm-6 col-12 text-sm-end">
                                <div class="profile">
                                    <img :src="users.profile" @click="toggleDropdown" />
                                    <p class="d-none d-md-inline-block mb-0 ms-4 me-3">
                                        {{ users.first_name }} {{ users.last_name }}
                                    </p>
                                    <div class="profile-link" :class="{ show: isDropdownOpen }">
                                        <router-link @click="closeDropdown" class="nav-link text-primary mt-0" href="#"
                                            :to="{ path: '/user_info' }" :class="{ active: $route.path === '/user_info' }">
                                            <i class="bi bi-person my-icon"></i>Profile
                                        </router-link>
                                        <a @click="logout" class="nav-link text-primary mt-0" href="#">
                                          
                                            <i class="bi bi-box-arrow-right my-icon"></i>Logout
                                        </a>
                                        <a @click="closeDropdown" class="nav-link text-primary" href="#">
                                            <i class="bi bi-gear my-icon"></i>Change Password
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <main class="p-4">
                <slot></slot>
            </main>
        </div>
    </div>
</template>
<script>

import VueCookies from 'vue-cookies'
import http from "../../htpp.common";
export default {
    emits: ["isLogin"],
    data: () => ({
        isDropdownOpen: false,
        isLinkActiveTeacher: false,
        isLinkActiveStudent: false,
        isLinkActiveAttendance: false,
        isLinkActiveScore: false,
        isLinkActiveClass: false,
        users: [],
    }),
    computed: {
        isActive() {
            return (path) => {
                return this.$route.path === path;
            };
        },
    },
    methods: {
        logout() {
            http
                .post(
                    "/api/v1/auth/logout",
                    {},
                    {
                        headers: {
                            Authorization: "Bearer " + localStorage.getItem("access_token"),
                        },
                    }
                )
                .then(() => {
                    // Remove the access token from local storage
                    localStorage.removeItem("access_token");
                    sessionStorage.removeItem("email");

                    // Redirect to the login page
                    // this.$router.push('/login');
                    this.$emit("isLogin", false, this.email);
                    this.fetchData();
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;
        },
        closeDropdown() {
            this.isDropdownOpen = false;
        },
        toggleLinks(link) {
            if (link === "teacher") {
                this.isLinkActiveTeacher = !this.isLinkActiveTeacher;
                // this.isLinkActiveStudent = false;
            } else if (link === "student") {
                this.isLinkActiveStudent = !this.isLinkActiveStudent;
                // this.isLinkActiveTeacher = false;
            } else if (link === "class") {
                this.isLinkActiveClass = !this.isLinkActiveClass;
                // this.isLinkActiveTeacher = false;
            }else if (link === "attendance") {
                this.isLinkActiveAttendance = !this.isLinkActiveAttendance;
                // this.isLinkActiveTeacher = false;
            }else if (link === "score") {
                this.isLinkActiveScore = !this.isLinkActiveScore;
                // this.isLinkActiveTeacher = false;
            }
        },
        setCookie(name, value) {
            VueCookies.set(name, value, { expires: 1 });
        },
        getCookie(name) {
            return VueCookies.get(name);
        },

        save() {
            http
                .get("/api/v1/auth/user")
                .then((response) => {
                    this.users = response.data.data;
                    this.setCookie('first_name', this.users.first_name)
                    this.setCookie('last_name', this.users.last_name)
                    this.setCookie('profile', this.users.profile)

                    console.log(response.data.data);
                })
                .catch((error) => {
                    console.log(error);
                });
        },

    },
    mounted() {
        this.save();
    },

};
</script>
<style scoped>
@import url(https://unpkg.com/@webpixels/css@1.1.5/dist/index.css);

/* Bootstrap Icons */
@import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");

header {
    background: #000;
}

.bg-surface-primary {
    background: #000;
}

.nav-link {
    color: red;
}

.my-link {
    color: #000;
    font-weight: bold;
    text-decoration: none;
    background: #000;
}

.my-link.active {
    color: #fff;
    background-color: #007bff;
}

.profile {
    position: relative;
}

.profile img {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    cursor: pointer;
}

.profile .profile-link {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    background: var(--light);
    padding: 10px 0;
    box-shadow: 4px 4px 16px rgba(0, 0, 0, .1);
    border-radius: 10px;
    width: 185px;
    opacity: 0;
    pointer-events: none;
    transition: all .3s ease;
    background: #bab1b1;
}

.profile .profile-link.show {
    opacity: 1;
    pointer-events: visible;
    top: 100%;
}

.profile .profile-link a {
    padding: 10px 16px;
    display: flex;
    grid-gap: 10px;
    font-size: 14px;
    color: var(--dark);
    align-items: center;
    transition: all 0.3s ease;
}

.profile .profile-link a:hover {
    background: var(--grey);
}

.my-icon {
    font-size: 20px;
}

/* .container-fluid{
 background: #000;
 background: #bab1b1;
} */
#sidebarCollapse {
    background: var(--light);
}
</style>
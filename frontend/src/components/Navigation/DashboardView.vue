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
                <a class="navbar-brand py-lg-2 mb-lg-5 px-lg-6 me-0 " href="#" >
                    <!-- <img src="https://cdn-icons-png.flaticon.com/512/855/855601.png"  alt="..."> -->
                    <h3 class="text-dark text-center"><b>PRINAVISCHOOL</b></h3>
                </a>
                <!-- Collapse -->
                <div class="collapse navbar-collapse">
                    <!-- Navigation -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link class="nav-link text-primary" href="#" :to="{ path: '/home' }"
                                :class="{ 'active': $route.path === '/' }">
                                <i class="bi bi-house my-icon"></i> Dashboard
                            </router-link>

                            <!-- //teacher management -->

                            <router-link @click="toggleLinks('teacher')" class="nav-link text-primary" href="#"
                                :to="{ path: '/home' }" :class="{ 'active': $route.path === '/' }">
                                <i class="bi bi-person my-icon"></i> Teacher management <i
                                    class="bi bi-sort-down my-icon ms-4"></i>
                            </router-link>
                            <router-link v-show="isLinkActiveTeacher" class="nav-link text-primary ms-4" href="#"
                                :to="{ path: '/student_list' }" :class="{ 'active': $route.path === '/student_list' }">
                                <i class="bi bi-list my-icon"></i> Teacher List
                            </router-link>
                            <router-link v-show="isLinkActiveTeacher" class="nav-link text-primary ms-4" href="#"
                                :to="{ path: '/teacher' }" :class="{ 'active': $route.path === '/teacher' }">
                                <i class="bi bi-gear my-icon"></i> Teacher Sitting
                            </router-link>
                            <router-link v-show="isLinkActiveTeacher" class="nav-link text-primary ms-4" href="#"
                                :to="{ path: '/home' }" :class="{ 'active': $route.path === '/' }">
                                <i class="bi bi-check2-circle my-icon"></i>Teacher Attendance
                            </router-link>
                        </li>

                        <!-- //student management -->

                        <li class="nav-item">
                            <router-link @click="toggleLinks('student')" class="nav-link text-primary" href="#"
                                :to="{ path: '/student' }" :class="{ 'active': $route.path === '/student' }">
                                <i class="bi bi-people my-icon"></i> Student management <i
                                    class="bi bi-sort-down my-icon ms-4"></i>
                            </router-link>
                            <router-link v-show="isLinkActiveStudent" class="nav-link text-primary ms-4" href="#"
                                :to="{ path: '/student_list' }" :class="{ 'active': $route.path === '/student_list' }">
                                <i class="bi bi-list my-icon"></i> Student List
                            </router-link>
                            <router-link v-show="isLinkActiveStudent" class="nav-link text-primary ms-4" href="#"
                                :to="{ path: '/teacher' }" :class="{ 'active': $route.path === '/teacher' }">
                                <i class="bi bi-gear my-icon"></i>Student Sitting 
                            </router-link>
                            <router-link v-show="isLinkActiveStudent" class="nav-link text-primary ms-4" href="#"
                                :to="{ path: '/home' }" :class="{ 'active': $route.path === '/' }">
                                <i class="bi bi-clipboard-check my-icon"></i> Student Score
                            </router-link>
                            <router-link v-show="isLinkActiveStudent" class="nav-link text-primary ms-4" href="#"
                                :to="{ path: '/report_view' }" :class="{ 'active': $route.path === '/report_view' }">
                                <i class="bi bi-check2-circle my-icon"></i>Student Attendance
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link text-primary" href="#" :to="{ path: '/class' }"
                                :class="{ 'active': $route.path === '/class' }">
                                <i class="bi bi-building my-icon"></i> Class management
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link text-primary" href="#" :to="{ path: '/schedule' }"
                                :class="{ 'active': $route.path === '/schedule' }">
                                <i class="bi bi-table"></i> Schedule
                            </router-link>
                        </li>
                    </ul>
                    <!-- Divider -->
                    <hr class="navbar-divider my-5 opacity-20">
                    <div class="mt-auto"></div>
                </div>
            </div>
        </nav>
        <div class="h-screen flex-grow-1 overflow-y-lg-auto ">
            <!-- Header -->
            <header class="bg-surface-primary border-bottom pt-6 sticky-top">
                <div class="container-fluid mt-3">
                    <div class="mb-npx mb-7" >
                        <div class="row align-items-center">
                            <div class="col-sm-6 col-12 mb-4 mb-sm-0">
                                <!-- Title -->
                                <h1 class="h2 mb-0 ls-tight">SCHOOL MANAGEMENT</h1>
                            </div>
                            <!-- profile -->
                            <div class="col-sm-6 col-12 text-sm-end">
                                <div class="profile">
                                    <img src="https://images.unsplash.com/photo-1610271340738-726e199f0258?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80"
                                        @click="toggleDropdown">
                                    <p class="d-none d-md-inline-block mb-0 ms-4 me-3">NONG PHLOEUT</p>
                                    <div class="profile-link" :class="{ show: isDropdownOpen }">
                                        <router-link @click="closeDropdown" class="nav-link text-primary mt-0" href="#"
                                            :to="{ path: '/user_info' }"
                                            :class="{ 'active': $route.path === '/user_info' }">
                                            <i class="bi bi-person my-icon"></i>Profile
                                        </router-link>
                                        <router-link @click="logout" class="nav-link text-primary mt-0" href="#"
                                            :to="{ path: '/student_list' }"
                                            :class="{ 'active': $route.path === '/student_list' }">
                                            <i class="bi bi-box-arrow-right my-icon"></i>Logout
                                        </router-link>
                                        <router-link @click="closeDropdown" class="nav-link text-primary" href="#"
                                            :to="{ path: '/student_list' }"
                                            :class="{ 'active': $route.path === '/student_list' }">
                                            <i class="bi bi-gear my-icon"></i>Sitting
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                            <!-- profile -->
                        </div>
                        <!-- Nav -->
                        <!-- <ul class="nav nav-tabs mt-4 overflow-x border-0">
                            <li class="nav-item ">
                                <a href="#" class="nav-link active">Student List</a>
                            </li>
                            <li class="nav-item">
                                <router-link class="nav-link text-primary" href="#" :to="{ path: '/student_list' }"
                                    :class="{ 'active': $route.path === '/student_list' }">
                                    <i class="bi bi-person"></i> Teacher management
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link font-regular">File requests</a>
                            </li>
                        </ul> -->
                    </div>
                </div>
            </header>
            <main>
                <slot></slot>
            </main>
        </div>
    </div>
</template>
<script>
import http from '../../htpp.common.js'
export default {
    emits: ['isLogin'],
    data: () => ({
        isDropdownOpen: false,
        isLinkActiveTeacher: false,
        isLinkActiveStudent: false,

    }),
    computed: {
        isActive() {
            return (path) => {
                return this.$route.path === path
            }
        }
    },

    methods: {
        logout() {
            console.log(localStorage.getItem('access_token'))
            http.post('/api/v1/auth/logout')
                .then(() => {
                    sessionStorage.removeItem('email');
                    this.$router.push("/");
                    console.log('logout sess');
                    this.$emit('isLogin', false, this.email);
                })
                .catch(error => {
                    console.log(error);
                });
        },

        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;
        },
        closeDropdown() {
            this.isDropdownOpen = false;
        },
        toggleLinks(set) {
            if (set === 'teacher') {
                this.isLinkActiveTeacher = !this.isLinkActiveTeacher;
            } else if (set === 'student') {
                this.isLinkActiveStudent = !this.isLinkActiveStudent;
            }
        }

    }
}

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
    width: 160px;
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
    transition: all .3s ease;
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
#sidebarCollapse{
    background: var(--light);
 
}



</style>
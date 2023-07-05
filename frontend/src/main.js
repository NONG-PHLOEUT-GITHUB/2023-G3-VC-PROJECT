// import { createApp } from 'vue'
// import App from './App.vue'

// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'
// createApp(App).use(router).mount('#app')

import { createApp } from 'vue'
import App from './App.vue'
// import router from './router'
import {createRouter , createWebHistory } from 'vue-router'

import CreateUserForm from './views/Dashboard/CreateUserForm.vue'
import ResetPassword from './views/Login/ResetPassword.vue'
import ForgotPassword from './views/Login/ForgotPassword.vue'
import SetupPassword from './views/Login/SetupPassword.vue'
import AttendanceList from './views/Student/AttendanceList.vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
const router = createRouter({
    history:createWebHistory(),
    routes:[
        { path: '/createpage' , component: CreateUserForm},
        { path: '/resetpasspage' , component: ResetPassword},
        { path: '/forgotpassword' , component: ForgotPassword},
        { path: '/setuppassword' , component: SetupPassword},
        { path: '/attendancelist' , component: AttendanceList}
    ]
})
createApp(App).use(router).mount('#app')

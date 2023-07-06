import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/Director/DirectorDashboard.vue';
import UserInfo from '../views/UserInfo/UserDetail.vue';
import TeacherView from '../views/Teacher/TeacherView.vue';
import StudentList from '../views/Director/StudentList.vue';
import ClassView from '../views/Director/ClassView.vue';
import CreateUserForm from '../views/Dashboard/CreateUserForm.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/student',
    name: 'student',
    component: StudentList
  },
  {
    path: '/teacher',
    name: '/teacher',
    component: TeacherView
  },
  {
    path: '/class',
    name: '/class',
    component: ClassView
  },
  {
    path: '/createUser',
    name: '/createUser',
    component: CreateUserForm
  },
  {
    path: '/user_info',
    name: '/user_info',
    component: UserInfo
  },

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router

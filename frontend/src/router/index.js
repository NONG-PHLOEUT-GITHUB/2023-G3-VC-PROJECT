import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/Director/DirectorDashboard.vue';
// import StudentView from '../views/Student/StudentView.vue';
import TeacherList from '../views/Director/TeacherList.vue';
import ScheduleView from '../views/Director/ScheduleView.vue';
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
    name: 'teacher',
    component: TeacherList
  },
  {
    path: '/class',
    name: 'class',
    component: ClassView
  },
  {
    path: '/schedule',
    name: 'schedule',
    component: ScheduleView
  },
  {
    path: '/createUser',
    name: '/createUser',
    component: CreateUserForm
  },

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router

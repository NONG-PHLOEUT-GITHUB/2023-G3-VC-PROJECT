import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/Director/DirectorDashboard.vue';
// import StudentView from '../views/Student/StudentView.vue';
import TeacherList from '../views/Director/TeacherList.vue';
import ScheduleView from '../views/Director/ScheduleView.vue';
import UserInfo from '../views/UserInfo/UserDetail.vue';
import StudentList from '../views/Director/StudentList.vue';
import MonthlyReport from '../views/Director/MonthlyReport.vue';
import ClassView from '../views/Director/ClassView.vue';
import CreateUserForm from '../views/Dashboard/CreateUserForm.vue';
import LoginView from '../views/Authentication/LoginView2.vue';
import DashboardView from '../components/Navigation/DashboardView.vue';
// import FormFogetPassword from '../views/Authentication/ForgotPassword.vue';
import FormFogetPassword from '../components/HelloWorld.vue';

import SaveListStudent from '@/views/Student/SaveListStudent.vue';
import TeacherDetail from '../views/Student/StudentDetial.vue'
import AttendanceList from '../views/Student/AttendanceList.vue'
const routes = [
  {
    path: '/login',
    name: 'login',
    component: LoginView,
    meta:{
      isRequired: true
    }
  },
  {
    path: '/home',
    name: 'home',
    component: HomeView
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: DashboardView
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
  {
    path: '/user_info',
    name: '/user_info',
    component: UserInfo
  },
  {
    path: '/forgot_password',
    name: '/forgot_password',
    component: FormFogetPassword
  },
  {
    path: '/student_list',
    name: 'student_list',
    component: SaveListStudent
  },
  {
    path: '/student_detail/:id',
    name: '/student_detail',
    meta: {
      auth: true
    },
    component: TeacherDetail,
  },
  {

    path: '/monthly_report',
    name: 'monthly_report',
    component: MonthlyReport
  },
  {

    path: '/attendance_list',
    name: 'attendance_list',
    component: AttendanceList
  },
  

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

// https://beginnersoftwaredeveloper.com/how-do-i-protect-my-vue-router/?expand_article=1
router.beforeEach((to,from,next) => {
  const isUserAuthenticated = null;

  const isRequired = to.matched.some(
    (record) => record.meta.isRequired
  );

  if(isRequired && !isUserAuthenticated){
    next('/login');
  }else{
    next();
  }
})



export default router

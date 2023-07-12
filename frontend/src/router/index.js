import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/Director/DirectorDashboard.vue';
import TeacherList from '../views/Director/TeacherList.vue';
import ScheduleView from '../views/Director/ScheduleView.vue';
import UserInfo from '../views/UserInfo/UserDetail.vue';

import StudentList from '../views/Director/StudentList.vue';
import MonthlyReport from '../views/Director/MonthlyReport.vue';
import ReportView from '../views/Director/ReportView.vue';
import ClassView from '../views/Director/ClassView.vue';
import CreateUserForm from '../views/Dashboard/CreateUserForm.vue';
import AttendanceList from '../views/Student/AttendanceList.vue';
import CheckAttendance from '../views/Student/CheckAttendance.vue';
import StudentMostAbsence from '../views/Student/StudentMostAbsence.vue';
import StudentAttendanceDetail from '../views/Student/StudentAttendanceDetail.vue';
// import StudentDetail from '../views/Student/StudentDetail.vue';
import TeacherAttendanceList from '../views/Teacher/TeacherAttendanceList.vue';
import TeacherMostAbsence from '../views/Teacher/TeacherMostAbsence.vue';
import LoginView from '../views/Authentication/LoginView2.vue';
import DashboardView from '../components/Navigation/DashboardView.vue';
// import FormFogetPassword from '../views/Authentication/ForgotPassword.vue';
import FormFogetPassword from '../components/HelloWorld.vue';
import FormResetNewPassword from '../views/Authentication/ResetNewPassword.vue';

import SaveListStudent from '@/views/Student/SaveListStudent.vue';
import TeacherDetail from '../views/Student/StudentDetial.vue'
/// change password
import ChangePassword from '../views/Authentication/ChangePassword.vue';

import EditUserForm from '../views/Dashboard/EditUserForm.vue'

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
    path: '/attendancelist',
    name: '/attendancelist',
    component: AttendanceList
  },
  {
    path: '/studentmostabsence',
    name: '/studentmostabsence',
    component: StudentMostAbsence
  },
  {
    path: '/studentattendancedetail/:id',
    name: '/studentattendancedetail',
    component: StudentAttendanceDetail
  },
  {
    path: '/teacherattendancelist/:id',
    name: '/teacherattendancelist',
    component: TeacherAttendanceList,
    props:true

  },
  {
    path: '/teachermostabsence',
    name: '/teachermostabsence',
    component: TeacherMostAbsence
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
  {

    path: '/check_attendance',
    name: 'check_attendance',
    component: CheckAttendance
  },
  {

    path: '/change_password',
    name: 'change_password',
    component: ChangePassword
  },

  {
    name: 'edit',
    path: '/edit/:id',
    component: EditUserForm
  },
  {
    path: '/report_view',
    name: 'report_view',
    component: ReportView
  },
<<<<<<< HEAD
  
  
  

=======
  {
    path: '/forgot_password',
    name: '/forgot_password',
    component: FormFogetPassword
  },
  {
    path: '/reset_new_password',
    name: 'reset_new_password',
    component: FormResetNewPassword
  }
>>>>>>> 26d5e816f28e27e68904f5ed61ccd8274ca0cae5
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

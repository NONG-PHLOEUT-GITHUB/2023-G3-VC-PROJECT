import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/Director/DirectorDashboard.vue';
// import StudentView from '../views/Student/StudentView.vue';
import TeacherList from '../views/Teacher/TeacherList.vue';
import TeacherListView from '../views/Teacher/SaveListTeacher.vue';
import ScheduleView from '../views/Director/ScheduleView.vue';
import UserInfo from '../views/UserInfo/UserDetail.vue';
import StudentList from '../views/Student/StudentList.vue';
// import StudentList from '../views/Director/StudentList.vue';
import MonthlyReport from '../views/Director/MonthlyReport.vue';
import ReportView from '../views/Director/ReportView.vue';
import ClassView from '../views/Director/ClassView.vue';
import CreateUserForm from '../views/Dashboard/CreateUserForm.vue';
import CreateClassForm from '../views/Dashboard/CreateClassForm.vue';
import AttendanceList from '../views/Student/AttendanceList.vue';
import StudentGraph from '../views/Student/StudentGraph.vue';
import StudentMostAbsence from '../views/Student/StudentMostAbsence.vue';
import StudentDetail from '../views/Student/StudentDetial.vue';
import StudentAttendanceDetail from '../views/Student/StudentAttendanceDetail.vue';
import StudentListScore from '../views/Student/StudentListScore.vue';
import TeacherAttendanceDetail from '../views/Teacher/TeacherAttendanceDetail.vue';
import CheckAttendance from '../views/Student/CheckAttendance.vue'
import TeacherAttendanceList from '../views/Teacher/TeacherAttendanceList.vue';
import TeacherMostAbsence from '../views/Teacher/TeacherMostAbsence.vue';
import DashboardView from '../components/Navigation/DashboardView.vue';

import SaveListStudent from '@/views/Student/SaveListStudent.vue';
import TeacherDetail from '../views/Student/StudentDetial.vue'
import EditUserForm from '../views/Dashboard/EditUserForm.vue'
import CheckStudentAttendacne from '../views/Student/CheckStudentAttendance.vue';

//authentication router
import FormResetNewPassword from '../views/Authentication/ResetNewPassword.vue';
import LoginView from '../views/Authentication/LoginView.vue';
// import FormFogetPassword from '../components/HelloWorld.vue';
import ChangePassword from '../views/Authentication/ChangePassword.vue';

const routes = [
  {
    path: '/login',
    name: 'login',
    component: LoginView,
    // meta:{
    //   isRequired: true
    // }
  },
  {
    path: '/home',
    name: 'home',
    component: HomeView,
    meta:{requireAuth:true}
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
    path: '/class_list',
    name: 'class_list',
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
    path: '/createClass',
    name: '/createClass',
    component: CreateClassForm
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
    path: '/studentdetail',
    name: '/studentdetail',
    component: StudentDetail
  },
  {
    path: '/studentattendancedetail/:id',
    name: '/studentattendancedetail',
    component: StudentAttendanceDetail
  },
  {
    path: '/teacherattendancedetail/:id',
    name: '/teacherattendancedetail',
    component: TeacherAttendanceDetail
  },
  {
    path: '/checkAttendance',
    name: '/checkAttendance',
    component: CheckAttendance
  },
  {
    path: '/teacherattendancelist',
    name: '/teacherattendancelist',
    component: TeacherAttendanceList
  },
  {
    path: '/teachermostabsence',
    name: '/teachermostabsence',
    component: TeacherMostAbsence
  },
  // {
  //   path: '/forgot_password',
  //   name: '/forgot_password',
  //   component: FormFogetPassword
  // },
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
  {
    path: '/teacher_list_view',
    name: 'teacher_list_view',
    component: TeacherListView
  },
  {
    path: '/class_rooms/:id',
    name: 'class_rooms',
    meta: {
      auth: true
    },
    component: StudentList
  },
  {
    path: '/check_student_attendance',
    name: 'check_student_attendance',
    component: CheckStudentAttendacne
  },
  {
    path: '/reset_new_password',
    name: 'reset_new_password',
    component: FormResetNewPassword
  },

  {
    path: '/studentgraph',
    name: '/studentgraph',
    component: StudentGraph,
  },
  {
    path: '/studentlistscore',
    name: '/studentlistscore',
    component: StudentListScore,
  },
  // {
  //   path: '/404',
  //   name: '404',
  //   component: NotFoundView
  // }
  // {
  //   path: '/home',
  //   name: 'home',
  //   component: HomeView,
  //   meta: {
  //     requireAuth: true,
  //     roles: ['admin']
  //   },
  //   beforeEnter: checkRole
  // },

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

// https://beginnersoftwaredeveloper.com/how-do-i-protect-my-vue-router/?expand_article=1

router.beforeEach((to,from, next) => {
  const isUserAuthenticated = null;
  const isRequiredAuth = to.matched.some(
    (record) => record.meta.isRequiredAuth
  );
  if (isUserAuthenticated  && !isRequiredAuth) {
    next('/login');
  }else{
    next();
  }
})

// function checkRole(to, from, next) {
//   const userAuthStore = useUserAuth();
//   const currentUser = userAuthStore.currentUser;
//   if (currentUser && to.meta.roles.includes(currentUser.role)) {
//     next();
//   } else {
//     next({ name: 'unauthorized' });
//   }
// }


export default router

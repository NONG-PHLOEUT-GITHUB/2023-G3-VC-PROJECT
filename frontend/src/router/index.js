import { createRouter, createWebHistory } from 'vue-router'
//admind dashboard router =================================================================
import DashboardHomeView from '@/views/Director/DirectorDashboard.vue';
import AddTeacher from '../views/Teacher/TeacherList.vue';
//admind dashboard router =================================================================
import TeacherListView from '../views/Teacher/SaveListTeacher.vue';
import ScheduleView from '../views/Director/ScheduleView.vue';
import StudentList from '../views/Student/StudentList.vue';
import MonthlyReport from '../views/Director/MonthlyReport.vue';
import ReportView from '../views/Director/ReportView.vue';
import ClassView from '../views/Director/ClassView.vue';
import CreateUserForm from '../views/Dashboard/CreateUserForm.vue';
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
import FormResetNewPassword from '@/views/Authentication/ResetNewPasswordForm.vue';

import GiveFeedBackForm from '../views/Teacher/GiveFeedBackForm.vue'
//authentication router =================================================================
import ResetNewPasswordForm from '@/views/Authentication/ResetNewPasswordForm.vue';
import LoginForm from '../views/Authentication/LoginForm.vue';
import ForgotPasswordFrom from '@/views/Authentication/ForgotPasswordForm.vue';
import ChangePasswordForm from '../views/Authentication/ChangePasswordForm.vue';
//user router ===========================================================================
import UserProfile from '@/views/UserInfo/UserProfile.vue';
//dashboard router ======================================================================
import AdminDashboard from '@/components/AdminDashboard.vue';
import TeacherDashboard from '@/components/TeacherDashboard.vue';
import StudentDashboard from '@/components/StudentDashboard.vue';
//student dashboard router ==============================================================
import StudnetAcadmics from '@/views/Student/StudentView.vue';
import StudentHomeView from '@/views/Student/StudentHomeView';
import StudentAttendanceView from '@/views/Student/StudentAttendanceView.vue';
import StudentScoreView from '@/views/Student/StudentScoreView.vue';
//teacher dashboard router =============================================================
import ClassroomView from '@/views/Teacher/ClassroomView.vue';
const routes = [
  {
    path: '/',
    name: 'LoginForm',
    component: LoginForm,
  },
  // {
  //   path: '/login',
  //   name: 'LoginForm',
  //   component: LoginForm,
  // },
  {
    path: '/reset-new-password/:token',
    name: 'ResetNewPasswordForm',
    component: ResetNewPasswordForm
  },
  //   path: '/reset-new-password/:token',
  //   name: 'ResetNewPasswordForm',
  //   component: ResetNewPasswordForm
  // },
  {

    path: '/change_password',
    name: 'ChangePasswordForm',
    component: ChangePasswordForm
  },
    {
    path: '/forgot-password',
    name: 'FormFogetPassword',
    component: ForgotPasswordFrom
  },
    {
    path: '/user-profile',
    name: 'UserProfile',
    component: UserProfile
  },
  {
    path: '/home',
    name: 'home',
    component: DashboardHomeView,
    meta:{requireAuth:true}
  },
  // =============================
  {
    path: '/studnet-home',
    name: 'StudentHomeView',
    component: StudentHomeView,
  },
  {
    path: '/studnet-attendance',
    name: 'StudentAttendanceView',
    component: StudentAttendanceView,
  },
  {
    path: '/studnet-scores',
    name: 'StudentScoreView',
    component: StudentScoreView,
  },
  // =============================
  {
    path: '/student-acadamice',
    name: 'StudnetAcadmics',
    component: StudnetAcadmics,
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: DashboardView
  },
// ============main dashboard=======
  {
    path: '/admin-dashboard',
    name: 'AdmindDashboard',
    component: AdminDashboard
  },
  {
    path: '/student-dashboard',
    name: 'StudentDashboard',
    component: StudentDashboard
  },



  {
    path: '/teacher-dashboard',
    name: 'TeacherDashboard',
    component: TeacherDashboard
  },


  {
    path: '/student-list',
    name: 'StudentList',
    component: StudentList
  },
  {
    path: '/add-teacher',
    name: 'AddTeacher',
    component: AddTeacher
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
    path: '/attendance-list',
    name: '/AttendanceList',
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
    path: '/check-attendance',
    name: '/checkAttendance',
    component: CheckAttendance
  },
  {
    path: '/teacherattendancelist',
    name: '/teacherattendancelist',
    component: TeacherAttendanceList
  },
  {
    path: '/teacher-most-absence',
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
    path: '/teacher_list',
    name: 'teacher_list',
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
  {
    path: '/feedback',
    name: 'feedback',
    component: GiveFeedBackForm
  },
  {
    path: '/teacher-classroom',
    name: 'ClassroomView',
    component: ClassroomView
  }
  

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

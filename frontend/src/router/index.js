import { createRouter, createWebHistory } from 'vue-router'
//admind dashboard router =================================================================
import DashboardHomeView from '@/views/admin/DirectorDashboard.vue'
import AddGuardian from '../views/Guardians/CreateGuardian.vue'
// import EditGuardian from '../views/Guardians/EditGuardian.vue';
import EditGuardian from '@/views/Guardians/EditGuardian.vue'
//admind dashboard router =================================================================
import TeacherListView from '../views/Teacher/SaveListTeacher.vue'
import StudentList from '../views/Student/StudentList.vue'
import ClassView from '../views/admin/ClassManagement.vue'
import CreateUserForm from '../views/dashboard/CreateUserForm.vue'
import AttendanceList from '../views/Student/AttendanceList.vue'
import StudentGraph from '../views/Student/StudentGraph.vue'
import StudentMostAbsence from '../views/Student/StudentMostAbsence.vue'
import StudentDetail from '../views/Student/StudentDetial.vue'
import StudentAttendanceDetail from '../views/attendances/StudentAttendanceDetail.vue'
import TeacherAttendanceDetail from '../views/Teacher/TeacherAttendanceDetail.vue'
import CheckAttendance from '../views/Student/CheckAttendance.vue'
import TeacherAttendanceList from '../views/Teacher/TeacherAttendanceList.vue'
import SaveListStudent from '@/views/Student/SaveListStudent.vue'
import TeacherDetail from '../views/Student/StudentDetial.vue'
import EditUserForm from '../views/dashboard/EditUserForm.vue'
import GiveFeedBackForm from '../views/Teacher/GiveFeedBackForm.vue'
import StudentScoreReport from '../views/Teacher/StudentScoreReport.vue'
//auth router =================================================================
import ResetNewPasswordForm from '@/views/auth/ResetNewPassword.vue'
import LoginForm from '@/views/auth/Login.vue'
import ForgotPasswordFrom from '@/views/auth/ForgotPassword.vue'
import ChangePasswordForm from '@/views/auth/ChangePassword.vue'
import NotFoundView from '@/views/auth/Notfound.vue'
//user router ===========================================================================
import UserProfile from '@/views/userInfor/UserProfile.vue'
//dashboard router ======================================================================
import TeacherHome from '@/views/Teacher/TeacherHome.vue'
//student dashboard router ==============================================================
import StudentAcadmics from '@/views/Student/StudentView.vue'
import StudentHomeView from '@/views/Student/StudentHomeView'
import StudentAttendanceView from '@/views/attendances/StudentAttendance.vue'
import StudentScoreView from '@/views/scores/StudentScoreView.vue'
import StudentScore from '@/views/scores/StudentScore.vue'
import StudentCommentView from '@/views/comment/Comment.vue'

//teacher dashboard router =============================================================
import ClassroomView from '@/views/Teacher/ClassroomView.vue'

//guadian  router =============================================================
import GuardianListView from '../views/Guardians/GuardianList.vue'

const routes = [
  {
    path: '/',
    name: 'FristLoginForm',
    component: LoginForm
  },
  {
    path: '/login',
    name: 'SecondLoginForm',
    component: LoginForm
  },
  {
    path: '/reset-new-password/:token',
    name: 'ResetNewPasswordForm',
    component: ResetNewPasswordForm
  },
  {
    path: '/change-password',
    name: 'ChangePasswordForm',
    component: ChangePasswordForm,
    meta: { requiresAuth: true }
  },
  {
    path: '/forgot-password',
    name: 'FormFogetPassword',
    component: ForgotPasswordFrom
  },
  {
    path: '/user-profile',
    name: 'UserProfile',
    component: UserProfile,
    meta: { requiresAuth: true }
  },

  // =============================
  {
    path: '/layout',
    component: () => import('@/views/layout/Layout.vue'),
    // To ensure that when navigating to child routes,
    // you stay within the parent route, you can set up your routes to be nested properly.
    // In your case, it seems like you have a parent route /layout with child routes /student-home and /student-comments.
    children: [
      {
        path: '', // Set the default child route
        redirect: 'student-home'
      },
      {
        path: '/student-home',
        name: 'StudentHomeView',
        component: StudentHomeView,
        meta: { requiresAuth: true, requiredRoles: [3] }
      },
      {
        path: '/student-comments',
        name: 'Student Comment',
        component: StudentCommentView,
        meta: { requiresAuth: true, requiredRoles: [3] }
      },
      {
        path: '/student-attendance',
        name: 'Student Attendance',
        component: StudentAttendanceView,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/student-scores',
        name: 'Student Score',
        component: StudentScoreView,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      // =============================
      {
        path: '/student-acadamice',
        name: 'StudentAcadmics',
        component: StudentAcadmics,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },

      // ============main dashboard=======
      {
        path: '/admin-dashboard',
        name: 'DashboardHomeView',
        component: DashboardHomeView,
        meta: { requiresAuth: true, requiredRoles: [1] }
      },

      {
        path: '/teacher-dashboard',
        name: 'Dashboard',
        component: TeacherHome,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      // ============main dashboard=======

      {
        path: '/student-list',
        name: 'Student List',
        component: StudentList,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/class-list',
        name: 'Class list',
        component: ClassView,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/createUser',
        name: '/createUser',
        component: CreateUserForm,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },

      {
        path: '/studentmostabsence',
        name: '/studentmostabsence',
        component: StudentMostAbsence,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/studentdetail',
        name: '/studentdetail',
        component: StudentDetail,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/studentattendancedetail/:id',
        name: '/studentattendancedetail',
        component: StudentAttendanceDetail,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/teacherattendancedetail/:id',
        name: '/teacherattendancedetail',
        component: TeacherAttendanceDetail,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/check-attendance',
        name: '/checkAttendance',
        component: CheckAttendance,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/teacher-attendance-list',
        name: 'Teacher Attendance List',
        component: TeacherAttendanceList,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/student_list',
        name: 'student_list',
        component: SaveListStudent,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/student_detail/:id',
        name: '/student_detail',
        component: TeacherDetail,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/attendance_list/:id',
        name: 'attendance',
        component: AttendanceList,
        props: true,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        name: 'edit',
        path: '/edit/:id',
        component: EditUserForm,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/class_rooms/:id',
        name: 'class_rooms',
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/studentgraph',
        name: '/studentgraph',
        component: StudentGraph,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/feedback/:id',
        name: 'feedback',
        component: GiveFeedBackForm,
        props: true,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/student-score-report/:id',
        name: 'student-score-report',
        component: StudentScoreReport,
        props: true,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/teacher-classroom',
        name: 'ClassroomView',
        component: ClassroomView,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/student-score',
        name: 'StudentScore',
        component: StudentScore,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/teacher_list',
        name: 'Teacher List',
        component: TeacherListView,
        meta: { requiresAuth: true, requiredRoles: [1] }
      },
      {
        path: '/guardian-list',
        name: 'Guardian List',
        component: GuardianListView,
        meta: { requiresAuth: true, requiredRoles: [1] }
      },
      {
        path: '/add-guadian',
        name: 'AddGuadian',
        component: AddGuardian,
        meta: { requiresAuth: true, requiredRoles: [1] }
      },
      {
        path: '/edit-guadian/:id',
        name: 'EditGuadian',
        component: EditGuardian,
        meta: { requiresAuth: true, requiredRoles: [1] }
      },

      {
        path: '/:pathMatch(.*)*', // matches any unknown path
        name: 'not-found',
        component: NotFoundView
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(process.env.VUE_APP_API_URL),
  routes
})

// https://beginnersoftwaredeveloper.com/how-do-i-protect-my-vue-router/?expand_article=1

// router.beforeEach((to, from, next) => {

//   const { isAuthenticated, role } = checkAuth();
//   const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
//   const requiredRole = to.meta.requiredRole;

//   if (requiresAuth && !isAuthenticated) {
//     next('/login');
//   }
//   else if (to.name === '') {
//     next('/student-home');
//   }
//   else if (requiredRole && !requiredRole.includes(role)) {
//     next('/login');
//   }
//    else {
//     next();
//   }
// })

// function checkAuth() {
//   const token = Cookies.get('access_token');
//   const role = Cookies.get('user_role');
//   return { isAuthenticated: !!token, role: parseInt(role) };
// }

export default router

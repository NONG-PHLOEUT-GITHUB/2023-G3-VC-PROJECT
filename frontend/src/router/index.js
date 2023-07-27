import { createRouter, createWebHistory } from 'vue-router'
import Cookies from 'js-cookie';
//admind dashboard router =================================================================
import DashboardHomeView from '@/views/Director/DirectorDashboard.vue';
import AddTeacher from '../views/Teacher/TeacherList.vue';
//admind dashboard router =================================================================
import TeacherListView from '../views/Teacher/SaveListTeacher.vue';
import StudentList from '../views/Student/StudentList.vue';
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
import SaveListStudent from '@/views/Student/SaveListStudent.vue';
import TeacherDetail from '../views/Student/StudentDetial.vue'
import EditUserForm from '../views/Dashboard/EditUserForm.vue'
import GiveFeedBackForm from '../views/Teacher/GiveFeedBackForm.vue'
//authentication router =================================================================
import ResetNewPasswordForm from '@/views/Authentication/ResetNewPasswordForm.vue';
import LoginForm from '../views/Authentication/LoginForm.vue';
import ForgotPasswordFrom from '@/views/Authentication/ForgotPasswordForm.vue';
import ChangePasswordForm from '../views/Authentication/ChangePasswordForm.vue';
// import NotFoundView from '@/views/Authentication/NotFoundView.vue';
//user router ===========================================================================
import UserProfile from '@/views/UserInfo/UserProfile.vue';
//dashboard router ======================================================================
// import AdminDashboard from '@/components/AdminDashboard.vue';
import TeacherDashboard from '@/components/TeacherDashboard.vue';
import StudentDashboard from '@/components/StudentDashboard.vue';
//student dashboard router ==============================================================
import StudentAcadmics from '@/views/Student/StudentView.vue';
import StudentHomeView from '@/views/Student/StudentHomeView';
import StudentAttendanceView from '@/views/Student/StudentAttendanceView.vue';
import StudentScoreView from '@/views/Student/StudentScoreView.vue';
import StudentScore from '@/views/Student/StudentScore.vue';

//teacher dashboard router =============================================================
import ClassroomView from '@/views/Teacher/ClassroomView.vue';




const routes = [
  {
    path: '/',
    name: 'FristLoginForm',
    component: LoginForm,
  },
  {
    path: '/login',
    name: 'SecondLoginForm',
    component: LoginForm,
  },
  {
    path: '/reset-new-password/:token',
    name: 'ResetNewPasswordForm',
    component: ResetNewPasswordForm
  },
  {

    path: '/change-password',
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
    component: UserProfile,
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/admin-dashboard',
    name: 'home',
    component: DashboardHomeView,
    meta:{
      requiresAuth:true
    }
  },
  // =============================
  {
    path: '/student-home',
    name: 'StudentHomeView',
    component: StudentHomeView,
  },
  {
    path: '/student-attendance',
    name: 'StudentAttendanceView',
    component: StudentAttendanceView,
  },
  {
    path: '/student-scores',
    name: 'StudentScoreView',
    component: StudentScoreView,
  },
  // =============================
  {
    path: '/student-acadamice',
    name: 'StudentAcadmics',
    component: StudentAcadmics,
  },
  
// ============main dashboard=======
  // {
  //   path: '/admin-dashboard',
  //   name: 'AdmindDashboard',
  //   component: AdminDashboard
  // },
  {
    path: '/student-dashboard',
    name: 'StudentDashboard',
    component: StudentDashboard,
    beforeRouteUpdate(to, from, next) {
      const StudentDashboard = true;
      if (StudentDashboard) {
        next('/student-home');
      } else {
        next();
      }
    }
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
  },
  {
    path: '/student-score',
    name: 'StudentScore',
    component: StudentScore
  },
  // {
  //   path: '/:pathMatch(.*)*', // matches any unknown path
  //   name: 'not-found',
  //   component: NotFoundView
  // }
  

]

const router = createRouter({
  history: createWebHistory(process.env.VUE_APP_API_URL),
  routes
});

// https://beginnersoftwaredeveloper.com/how-do-i-protect-my-vue-router/?expand_article=1

router.beforeEach((to, from, next) => {
  const isAuthenticated = checkAuth(); 
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

  if (requiresAuth && !isAuthenticated) {
    next('/login');
  } else {
    next();
  }
})

function checkAuth() {
  const token = Cookies.get('access_token');
  return !!token;
}

export default router;
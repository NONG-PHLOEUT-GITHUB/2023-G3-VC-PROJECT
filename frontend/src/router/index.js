import { createRouter, createWebHistory } from 'vue-router'
import jwtDecode from 'jwt-decode';

const routes = [
  {
    path: '/',
    name: 'FristLoginForm',
    component: () => import('@/views/auth/Login.vue')
  },
  {
    path: '/login',
    name: 'SecondLoginForm',
    component: () => import('@/views/auth/Login.vue')
  },
  {
    path: '/reset-new-password/:token',
    name: 'ResetNewPasswordForm',
    component: () => import('@/views/auth/ResetNewPassword.vue')
  },
  {
    path: '/change-password',
    name: 'ChangePasswordForm',
    component: () => import('@/views/auth/ChangePassword.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/forgot-password',
    name: 'FormFogetPassword',
    component: () => import('@/views/auth/ForgotPassword.vue')
  },

  // =============================
  {
    path: '/layout',
    component: () => import('@/views/layout/Layout.vue'),
    // To ensure that when navigating to child routes,
    // Stay within the parent route, you can set up your routes to be nested properly.
    children: [
      {
        path: '/user-profile',
        name: 'Personal Profile',
        component: () => import('@/views/userInfo/UserProfile.vue'),
        meta: { requiresAuth: true }
      },
      {
        path: '/student-home',
        name: 'Dashboard',
        component: () => import('@/views/dashboards/StudentDashboard.vue'),
        meta: { requiresAuth: true, requiredRole: [3] }
      },
      {
        path: '/student-comments',
        name: 'My Comments',
        component: () => import('@/views/comment/CommentStudentView.vue'),
        meta: { requiresAuth: true, requiredRole: [3] }
      },
      {
        path: '/student-attendance',
        name: 'My Attendance',
        component: () =>
          import('@/views/attendances/StudentAttendanceView.vue'),
        meta: { requiresAuth: true, requiredRole: [1, 2, 3] }
      },
      {
        path: '/student-score/view',
        name: 'My Score',
        component: () => import('@/views/scores/StudentExamView.vue'),
        meta: { requiresAuth: true, requiredRole: [1, 2, 3] }
      },

      {
        path: '/admin-dashboard',
        name: 'Admin Dashboard',
        component: () => import('@/views/dashboards/DirectorDashboard.vue'),
        meta: { requiresAuth: true, requiredRole: [1] }
      },

      {
        path: '/teacher-dashboard',
        name: 'Teacher Dashboard',
        component: () => import('@/views/dashboards/TeacherDashboard.vue'),
        meta: { requiresAuth: true, requiredRole: [1, 2] }
      },
      {
        path: '/student-list',
        name: 'Student Management',
        component: () => import('@/views/students/StudentList.vue'),
        meta: { requiresAuth: true, requiredRole: [1, 2] }
      },
      {
        path: '/class-list',
        name: 'Class Management',
        component: () => import('@/views/classroom/ClassManagement.vue'),
        meta: { requiresAuth: true, requiredRole: [1, 2] }
      },
      {
        path: '/create-user',
        name: 'Create new user',
        component: () => import('@/views/common/CreateUser.vue'),
        meta: { requiresAuth: true, requiredRole: [1, 2] }
      },
      {
        path: '/student/attendance/:id/details',
        name: 'Student Attendance Details',
        component: () =>
          import('@/views/attendances/StudentAttendanceDetail.vue'),
        meta: { requiresAuth: true, requiredRole: [1, 2] }
      },
      {
        path: '/teacher-attendance/:id/details',
        name: 'Teacher attendance detail',
        component: () =>
          import('@/views/attendances/TeacherAttendanceDetail.vue'),
        meta: { requiresAuth: true, requiredRole: [1, 2] }
      },
      {
        path: '/attendance/:classroomId/student',
        name: 'Check Attendance',
        component: () =>
          import('@/views/attendances/StudentAttendanceCheck.vue'),
        meta: { requiresAuth: true, requiredRole: [1, 2] }
      },
      {
        path: '/teacher-attendance-list',
        name: 'Teacher Attendance List',
        component: () =>
          import('@/views/attendances/TeacherAttendanceList.vue'),
        meta: { requiresAuth: true, requiredRole: [1, 2] }
      },
      {
        path: '/student/:id/details',
        name: 'Student Details',
        component: () => import('@/views/students/StudentDetial.vue'),
        meta: { requiresAuth: true, requiredRole: [1, 2] }
      },
      {
        path: '/attendance-report/:id/by-class',
        name: 'Attendance Details',
        component: () =>
          import('@/views/attendances/AttendanceReportInClass.vue'),
        props: true,
        meta: { requiresAuth: true, requiredRole: [1, 2] }
      },
      {
        path: '/user/:id/edit',
        name: 'Edit User Information',
        component: () => import('@/views/common/CreateUser.vue'),
        meta: { requiresAuth: true, requiredRole: [1, 2] }
      },
      {
        path: '/feedback/:studentId/student',
        name: 'Student Feedback',
        component: () => import('@/views/comment/SendComment.vue'),
        props: true,
        meta: { requiresAuth: true, requiredRole: [1, 2] }
      },
      {
        path: '/student/:classroomId/feedback',
        name: 'Student Feedback List',
        component: () => import('@/views/comment/StudentFeedbackList.vue'),
        props: true,
        meta: { requiresAuth: true, requiredRole: [1, 2] }
      },
      {
        path: '/student-score-report/:id',
        name: 'Student Score Report',
        component: () => import('@/views/scores/StudentScoreReport.vue'),
        props: true,
        meta: { requiresAuth: true, requiredRole: [1, 2] }
      },
      {
        path: '/teacher-classroom',
        name: 'My Class Teaching and Coordinator',
        component: () => import('@/views/classroom/ClassroomTeacher.vue'),
        meta: { requiresAuth: true, requiredRole: [1, 2] }
      },
      {
        path: '/classroom/:class_id/details',
        name: 'Classroom Details',
        component: () => import('@/views/classroom/ClassroomDetails.vue'),
        meta: { requiresAuth: true, requiredRole: [1, 2] }
      },
      {
        path: '/student-exam',
        name: 'Student Exam Management',
        component: () => import('@/views/scores/ExamManagment.vue'),
        meta: { requiresAuth: true, requiredRole: [1, 2] }
      },
      {
        path: '/student-score/:id/details',
        name: 'Student Score Details',
        component: () => import('@/views/scores/StudentScoreViewDetails.vue'),
        meta: { requiresAuth: true, requiredRole: [1, 2,3] }
      },
      {
        path: '/teacher-list',
        name: 'Teacher Management',
        component: () => import('@/views/teacher/TeacherList.vue'),
        meta: { requiresAuth: true, requiredRole: [1] }
      },
      {
        path: '/guardian-list',
        name: 'Guardian Management',
        component: () => import('@/views/guardians/GuardianList.vue'),
        meta: { requiresAuth: true, requiredRole: [1] }
      },
      {
        path: '/add-guadian',
        name: 'Create New Guardian',
        component: () => import('@/views/guardians/CreateGuardian.vue'),
        meta: { requiresAuth: true, requiredRole: [1] }
      },
      {
        path: '/guardian/:id/edit',
        name: 'Edit Guardian Information',
        component: () => import('@/views/guardians/CreateGuardian.vue'),
        meta: { requiresAuth: true, requiredRole: [1] }
      },
      {
        path: '/:pathMatch(.*)*', // matches any unknown path
        name: 'not-found',
        component: () => import('@/views/auth/Notfound.vue')
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(process.env.VUE_APP_API_URL),
  routes
})

// function checkAuth() {
//   const token = localStorage.getItem('access_token');
//   if (!token) return { isAuthenticated: false, role: null };

//   try {
//     const decoded = jwtDecode(token);
//     const isExpired = decoded.exp * 1000 < Date.now();
//     if (isExpired) {
//       localStorage.removeItem('access_token');
//       return { isAuthenticated: false, role: null };
//     }
//     return { isAuthenticated: true, role: decoded.role };
//   } catch (error) {
//     localStorage.removeItem('access_token');
//     return { isAuthenticated: false, role: null };
//   }
// }

router.beforeEach((to, from, next) => {
  const { isAuthenticated, role } = checkAuth()
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
  const requiredRole = to.meta.requiredRole

  if (requiresAuth && !isAuthenticated) {
    next('/login')
    localStorage.removeItem('access_token')
  } else if (requiredRole && !requiredRole.includes(role)) {
    next('/login')
    localStorage.removeItem('access_token')
  } else {
    next()
  }
})

function checkAuth() {
  const token = localStorage.getItem('access_token')
  const role = localStorage.getItem('user_role')
  return { isAuthenticated: !!token, role: parseInt(role) }
}

export default router

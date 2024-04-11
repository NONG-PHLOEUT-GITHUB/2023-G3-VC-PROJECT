import { createRouter, createWebHistory } from 'vue-router'

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
        path: '', // Set the default child route
        redirect: 'student-home'
      },
      {
        path: '/user-profile',
        name: 'My Profile',
        component: () => import('@/views/userInfor/UserProfile.vue'),
        meta: { requiresAuth: true }
      },
      {
        path: '/student-home',
        name: 'My page',
        component: () => import('@/views/students/StudentHomeView'),
        meta: { requiresAuth: true, requiredRoles: [3] }
      },
      {
        path: '/student-comments',
        name: 'Student Comment',
        component: () => import('@/views/comment/Comment.vue'),
        meta: { requiresAuth: true, requiredRoles: [3] }
      },
      {
        path: '/student-attendance',
        name: 'Student Attendance',
        component: () => import('@/views/attendances/StudentAttendance.vue'),
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/student-scores',
        name: 'Student Score',
        component: () => import('@/views/scores/StudentScoreView.vue'),
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },

      {
        path: '/admin-dashboard',
        name: 'Dashboard Home',
        component: () => import('@/views/admin/DirectorDashboard.vue'),
        meta: { requiresAuth: true, requiredRoles: [1] }
      },

      {
        path: '/teacher-dashboard',
        name: 'Dashboard',
        component: () => import('@/views/teacher/TeacherHome.vue'),
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },

      {
        path: '/student-list',
        name: 'Student List',
        component: () => import('@/views/students/StudentList.vue'),
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/class-list',
        name: 'Class list',
        component: () => import('@/views/admin/ClassManagement.vue'),
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/create-user',
        name: 'Create User',
        component: () => import('@/views/dashboard/CreateUserForm.vue'),
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/studentdetail',
        name: 'Student details',
        component: () => import('@/views/students/StudentDetial.vue'),
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/studentattendancedetail/:id',
        name: 'Student attendance detail',
        component: () => import('@/views/attendances/StudentAttendanceDetail.vue'),
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/teacherattendancedetail/:id',
        name: '/Teacher attendance detail',
        component: () => import('@/views/attendances/TeacherAttendanceDetail.vue'),
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      //
      {
        path: '/check-attendance',
        name: 'Check Attendance',
        component: () => import('@/views/attendances/CheckAttendance.vue'),
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/teacher-attendance-list',
        name: 'Teacher Attendance List',
        component: () => import('@/views/attendances/TeacherAttendanceList.vue'),
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/student-list',
        name: 'Student list',
        component: () => import('@/views/students/SaveListStudent.vue'),
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/student_detail/:id',
        name: '/student_detail',
        component: () => import('@/views/students/StudentDetial.vue'),
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/attendance_list/:id',
        name: 'Attendance Details',
        component: () => import('@/views/attendances/AttendanceList.vue'),
        props: true,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        name: 'edit',
        path: '/edit/:id',
        component: () => import('@/views/dashboard/EditUserForm.vue'),
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/class_rooms/:id',
        name: 'class_rooms',
        component: () => import('@/views/attendances/CheckAttendance.vue'),
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/feedback/:id',
        name: 'feedback',
        component: () => import('@/views/teacher/GiveFeedBackForm.vue'),
        props: true,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/student-score-report/:id',
        name: 'student-score-report',
        component: () => import('@/views/scores/StudentScoreReport.vue'),
        props: true,
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/teacher-classroom',
        name: 'Classroom Management',
        component: () => import('@/views/classroom/ClassroomView.vue'),
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/student-score',
        name: 'Student Score',
        component: () => import('@/views/scores/StudentScore.vue'),
        meta: { requiresAuth: true, requiredRoles: [1, 2] }
      },
      {
        path: '/teacher-list',
        name: 'Teacher List',
        component: () => import('@/views/teacher/SaveListTeacher.vue'),
        meta: { requiresAuth: true, requiredRoles: [1] }
      },
      {
        path: '/guardian-list',
        name: 'Guardian List',
        component: () => import('@/views/guardians/GuardianList.vue'),
        meta: { requiresAuth: true, requiredRoles: [1] }
      },
      {
        path: '/add-guadian',
        name: 'AddGuadian',
        component: () => import('@/views/guardians/CreateGuardian.vue'),
        meta: { requiresAuth: true, requiredRoles: [1] }
      },
      {
        path: '/edit-guadian/:id',
        name: 'EditGuadian',
        component: () => import('@/views/guardians/EditGuardian.vue'),
        meta: { requiresAuth: true, requiredRoles: [1] }
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

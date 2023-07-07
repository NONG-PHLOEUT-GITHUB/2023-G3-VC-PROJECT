import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/Director/DirectorDashboard.vue';
import UserInfo from '../views/UserInfo/UserDetail.vue';
import TeacherView from '../views/Teacher/TeacherView.vue';
import StudentList from '../views/Director/StudentList.vue';
import ClassView from '../views/Director/ClassView.vue';
import CreateUserForm from '../views/Dashboard/CreateUserForm.vue';
import LoginView from '../views/Authentication/LoginView2.vue';
import DashboardView from '../components/Navigation/DashboardView.vue';
// import FormFogetPassword from '../views/Authentication/ForgotPassword.vue';
import FormFogetPassword from '../components/HelloWorld.vue';

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
  {
    path: '/forgot_password',
    name: '/forgot_password',
    component: FormFogetPassword
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

import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/Director/DirectorDashboard.vue';
// import StudentView from '../views/Student/StudentView.vue';
import TeacherView from '../views/Teacher/TeacherView.vue';
import StudentList from '../views/Director/StudentList.vue';
import ClassView from '../views/Director/ClassView.vue';
import CreateUserForm from '../views/Dashboard/CreateUserForm.vue';
import AttendanceList from '../views/Student/AttendanceList.vue';
import StudentMostAbsence from '../views/Student/StudentMostAbsence.vue';
import TeacherAttendanceList from '../views/Teacher/TeacherAttendanceList.vue';
import TeacherMostAbsence from '../views/Teacher/TeacherMostAbsence.vue';

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
    path: '/teacherattendancelist',
    name: '/teacherattendancelist',
    component: TeacherAttendanceList
  },
  {
    path: '/teachermostabsence',
    name: '/teachermostabsence',
    component: TeacherMostAbsence
  },

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router

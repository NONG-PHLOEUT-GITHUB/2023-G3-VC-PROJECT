import { defineStore } from 'pinia'
// import { encryptData } from '@/utils/crypto';

import {
  userLogin,
  fetchUserLoged,
  forgotPassword,
  resetNewPassword,
  changeNewPassword,
  logout,
  updateProfile
} from '@/api/auth.js'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    authUser: [],
    token: null,
    isAuthenticated: false,
    userRole: null,
    isResetPassword: false,
    isReset: false,
    isChanged: false,
    isLogout: false,
    teacherID: null,
    studentScores:[],
    studentComments:[],
    exams:[]
  }),
  getters: {
    getUserId(state){
     return state.teacherID
    },
    getUserRole: state => {
      return state.userRole
    }
  },
  actions: {
    async login({ email, password }) {
      const response = await userLogin(email, password)
      this.userRole = response.data.user.role
      localStorage.setItem('user_role', response.data.user.role)
      // localStorage.setItem('user_role', encryptData(response.data.user.role)); // Assuming role is also returned
      this.token = response.data.access_token
      localStorage.setItem('access_token', response.data.access_token)
      return response
    },
    async fetchUser(exam_id) {
      const response = await fetchUserLoged(exam_id)
      this.studentScores = response.data.data.scores
      this.exams = response.data.data.exams
      this.studentComments = response.data.data.comments
      this.authUser = response.data.data
      this.teacherID = response.data.data.id
    },
    async logout() {
     return await logout()
    },
    async forgotPassword(email) {
     return await forgotPassword(email)
    },
    async userResetNewPassword(data) {
     return await resetNewPassword(data)
    },

    async userChangePassword(data) {
     return await changeNewPassword(data)
    },
    async userUpdateProfile(data) {
     return await updateProfile(data)
    }
  }
})

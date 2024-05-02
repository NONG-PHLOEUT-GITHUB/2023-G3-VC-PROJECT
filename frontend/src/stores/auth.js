import { defineStore } from 'pinia'

import {
  userLogin,
  fetchUserLoged,
  forgotPassword,
  resetNewPassword,
  changeNewPassword,
  logout
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
    teacherID: null
  }),
  getters: {
    user: state => state.authUser,

    getUserRole: state => {
      return state.userRole
    }
  },
  actions: {
    async login({ email, password }) {
      const response = await userLogin(email, password)
      this.userRole = response.data.user.role
      localStorage.setItem('user_role', response.data.user.role)
      this.token = response.data.access_token
      localStorage.setItem('access_token', response.data.access_token)
      return response
    },
    async fetchUser() {
      const response = await fetchUserLoged()
      this.authUser = response.data.data
      this.teacherID = response.data.data.id
    },
    async logout() {
     return await logout()
    },
    async forgotPassword(email) {
     return await forgotPassword(email)
    },
    async userResetNewPassword(token, password, password_confirmation) {
      await resetNewPassword(token, password, password_confirmation)
    },

    async userChangePassword(current_password, new_password) {
      await changeNewPassword(current_password, new_password)
    }
  }
})

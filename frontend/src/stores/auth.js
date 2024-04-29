import { defineStore } from 'pinia'

import {
  userLogin,
  fetchUserLoged,
  forgotPassword,
  resetNewPassword,
  changeNewPassword
} from '@/api/auth.js'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    authUser: null,
    token: null,
    isAuthenticated: false,
    userRole: null,
    isResetPassword: false,
    isReset: false,
    isChanged: false,
    isLogout: false,
    teacherID:null
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
      this.authUser = response.data
      this.teacherID = response.data.data.id
    },
    logout() {
      loadingStore.setLoading(true)
      this.isLogout = true
      // localStorage.removeItem("access_token");
      // localStorage.removeItem("user_role");
      this.isAuthenticated = false
    
    },
    async forgotPassword(email) {
      loadingStore.setLoading(true)
      try {
        const response = await forgotPassword(email)
        if (response.data.status === 'success') {
          this.isResetPassword = true
        } else {
          this.isResetPassword = false
        }
      } catch (error) {
        console.error('Error reset passw:', error)
      } finally {
        // loadingStore.setLoading(false)
      }
    },
    async userResetNewPassword(token, password, password_confirmation) {
      loadingStore.setLoading(true)
      try {
        const response = await resetNewPassword(token, password, password_confirmation)
        if (response.data.status === 'success') {
          this.authUser = response.data.user
          this.isReset = true
          localStorage.setItem('access_token', response.data.access_token)
        } else {
          this.isReset = false
        }
      } catch (error) {
        console.error('Error reset passw:', error)
      } finally {
        // loadingStore.setLoading(false)
      }
    },

    async userChangePassword(current_password, new_password) {
      loadingStore.setLoading(true)
      try {
        const response = await changeNewPassword(current_password, new_password)
        if (response.status === 200) {
          this.isChanged = true
        }
      } catch (error) {
        console.error('Error reset passw:', error)
      } finally {
        // loadingStore.setLoading(false)
      }
    }
  }
})

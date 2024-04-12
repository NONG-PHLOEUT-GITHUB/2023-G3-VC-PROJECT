import { defineStore } from 'pinia'
import {
  userLogin,
  fetchUserLoged,
  forgotPassword,
  resetNewPassword,
  changeNewPassword
} from '@/api/auth'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    loggedIn: false,
    role: null
  }),
  getters: {
    getUser: state => state.user,
    isLoggedIn: state => state.loggedIn
  },
  actions: {
    async login({ email, password }) {
      const response = await userLogin(email, password)
      this.user = response.data.user
      this.role = response.data.role
    },
    async fetchUser() {
      try {
        const response = await fetchUserLoged()
        this.user = response.data.user
      } catch (error) {
        throw error
      }
    },
    async forgotPassword({ email }) {
      try {
        await forgotPassword(email)
      } catch (error) {
        throw error
      }
    },
    async resetPassword({ token, password, password_confirmation }) {
      try {
        await resetNewPassword(token, password, password_confirmation)
      } catch (error) {
        throw error
      }
    },
    async changePassword({ current_password, new_password }) {
      try {
        await changeNewPassword(current_password, new_password)
      } catch (error) {
        throw error
      }
    }
  }
})

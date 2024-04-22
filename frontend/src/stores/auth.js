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
    isLogout: false
  }),
  getters: {
    user: (state) => state.authUser,
    role: (state) => state.userRole
  },
  actions: {
    async login({ email, password }) {
      try {
        const response = await userLogin(email, password)
        if (
          response.status === 200 &&
          response.data &&
          response.data.access_token
        ) {
          this.authUser = response.data.user
          localStorage.setItem('access_token', response.data.access_token)
          const userRole = response.data.user.role
          this.token = response.data.access_token
          console.log('user id in stat', userRole)
          // const loadingStore = useLoadingStore()
          // loadingStore.setLoading(true)
          this.isAuthenticated = true
        } else {
          this.isAuthenticated = false
        }
      } catch (error) {
        this.isAuthenticated = false
      }
    },
    async fetchUser() {
      // const loadingStore = useLoadingStore()
      loadingStore.setLoading(true)
      try {
        const data = await fetchUserLoged()
        this.authUser = data.data
        console.log('class teaching', data.data)
        console.log('user login', this.authUser)
      } catch (error) {
        console.error('Error fetching user:', error)
      } finally {
        // loadingStore.setLoading(false)
      }
    },
    logout() {
      // const loadingStore = useLoadingStore()
      loadingStore.setLoading(true)
      this.isLogout = true
      // localStorage.removeItem("access_token");
      // localStorage.removeItem("user_role");
      this.isAuthenticated = false
      loadingStore.setLoading(false)
    },
    async forgotPassword(email) {
      // const loadingStore = useLoadingStore()
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
      // const loadingStore = useLoadingStore()
      loadingStore.setLoading(true)
      try {
        const response = await resetNewPassword(
          token,
          password,
          password_confirmation
        )
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
      // const loadingStore = useLoadingStore()
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

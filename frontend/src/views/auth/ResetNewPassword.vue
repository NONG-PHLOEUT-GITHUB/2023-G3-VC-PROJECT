<template>
  <div class="container d-flex align-center justify-center" style="height: 100vh">
    <v-img src="../../../public/images/newpasword.jpg" cover></v-img>
    <v-col>
      <h4>Reset new your Password</h4>
      <span>Please complet form to reset new password.</span>
      <v-card width="500" elevation="0">
        <v-form ref="form" @submit.prevent="resetPassword" class="mt-4">
          <v-text-field
            :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
            :type="visible ? 'text' : 'password'"
            label="Enter your new Password"
            prepend-inner-icon="mdi-lock-outline"
            v-model="newPassword"
            :rules="passwordRules"
            variant="outlined"
            @click:append-inner="visible = !visible"
          >
          </v-text-field>
          <v-text-field
            :append-inner-icon="visibleConfirm ? 'mdi-eye-off' : 'mdi-eye'"
            :type="visibleConfirm ? 'text' : 'password'"
            label="Enter your confirm new Password"
            prepend-inner-icon="mdi-lock-outline"
            v-model="confirmPassword"
            :rules="confirmPasswordRule"
            variant="outlined"
            class="mt-4"
            @click:append-inner="visibleConfirm = !visibleConfirm"
          >
          </v-text-field>

          <v-card-actions class="pa-0">
            <v-spacer></v-spacer>
            <v-btn :disabled="expired" :to="forgot - password" class="bg-teal-darken-4 mt-4"
              >BacK</v-btn
            >
            <v-btn :disabled="!isPasswordValid" type="submit" class="bg-teal-darken-4 mt-4"
              >Reset Password</v-btn
            >
          </v-card-actions>
        </v-form>
      </v-card>
    </v-col>
  </div>
</template>
<script>
import { useAuthStore } from '@/stores/auth'
import { mapActions } from 'pinia'
export default {
  data() {
    return {
      dialog: false,
      visible: false,
      visibleConfirm: false,
      passwordShow: false,
      newPassword: '',
      confirmPassword: '',
      token: '',
      expired: true,
      passwordRules: [
        v => !!v || 'New password is required',
        v => (v && v.length >= 8) || 'Password must be 8  characters or more!'
      ],
      confirmPasswordRule: [
        v => !!v || 'Confirm new password is required',
        v => (v && v.length >= 8) || 'Password must be 8  characters or more!'
      ]
    }
  },

  methods: {
    ...mapActions(useAuthStore, ['userResetNewPassword']),
    resetPassword() {
      const data = {
        password: this.newPassword,
        password_confirmation: this.confirmPassword,
        token: this.token
      }
      this.userResetNewPassword(data)
        .then(response => {
          console.log(response)
          this.newPassword = ''
          this.confirmPassword = ''
          const userRole = response.data.data.role
          if (userRole === 1) {
            this.$router.push('/admin-dashboard')
          } else if (userRole === 2) {
            this.$router.push('/teacher-dashboard')
          } else {
            this.$router.push('/student-home')
          }
          localStorage.setItem('access_token', response.data.access_token)
          localStorage.setItem('user_role', userRole)
          this.$root.$notif('Reset Password successfully', {
            type: 'success',
            color: 'primary'
          })
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.confirmPasswordRule = ['The password field confirmation does not match']
          } else {
            if (error.response.status == 404) {
              this.expired = false
              this.$root.$notif('Token is expired', {
                type: 'error',
                color: 'primary'
              })
            }
          }
        })
    }
  },
  created() {
    this.token = this.$route.params.token
  },
  computed: {
    isPasswordValid() {
      return this.newPassword.length >= 8 && this.confirmPassword.length >= 8
    }
  },

  watch: {
    confirmPassword(value) {
      if (value !== this.newPassword) {
        this.confirmPasswordRule = ['The passwords do not match']
      } else {
        this.confirmPasswordRule = [
          v => !!v || 'Confirm new password is required',
          v => (v && v.length >= 8) || 'Password must be 8 characters or more!'
        ]
      }
    }
  }
}
</script>

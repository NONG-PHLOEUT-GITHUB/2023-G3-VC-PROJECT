<template>
  <div class="container d-flex align-center justify-center" style="height: 100vh">
    <v-flex xs12 md6 class="mb-7 w-50">
      <v-img
        src="https://img.freepik.com/free-vector/smartphone-data-protection-flat-composition-with-laptop-computer-screens-human-character-inserting-letters-into-password-vector-illustration_1284-82084.jpg?t=st=1714317897~exp=1714321497~hmac=f010f7dd77cab6e7a8153a5364bf4996a39a38e1833240d700df4aba6f3150a2&w=2000"
        cover
      ></v-img>
    </v-flex>
    <v-col>
      <h4>Reset your password</h4>
      <span>Please complet form to reset new password</span>
      <v-card width="500" elevation="0">
        <v-form ref="form" @submit.prevent="resetPassword" class="mt-4">
          <v-text-field
            :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
            :type="visible ? 'text' : 'password'"
            label="New password"
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
            label="Enter your confirm new password"
            prepend-inner-icon="mdi-lock-outline"
            v-model="confirmPassword"
            :rules="confirmPasswordRule"
            variant="outlined"
            @click:append-inner="visibleConfirm = !visibleConfirm"
          >
          </v-text-field>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn :disabled="!isPasswordValid" type="submit" class="bg-teal-darken-4 mt-4"
              >Reset Password</v-btn
            >
          </v-card-actions>
        </v-form>
      </v-card>
    </v-col>
  </div>
</template>

<!-- // https://vee-validate.logaretm.com/v4/tutorials/basics/ -->
<script>
import Cookies from 'js-cookie'
import http from '@/api/api'
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
    resetPassword() {
      const data = {
        password: this.newPassword,
        password_confirmation: this.confirmPassword,
        token: this.token
      }
      http
        .post(`auth/reset-password/${this.token}`, data, {})
        .then(response => {
          const ROLE = response.data.data.role
          const token = response.data.access_token
          if (ROLE === 1) {
            this.$router.push('/admin-dashboard')
          } else if (ROLE === 2) {
            this.$router.push('/teacher-dashboard')
          } else {
            this.$router.push('/student-dashboard')
          }

          // Set cookies
          localStorage.setItem('access_token', response.data.access_token)
          console.log('data', response.data.data.role)

          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 500,
            timerProgressBar: true,
            didOpen: toast => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })

          Toast.fire({
            icon: 'success',
            title: 'Your password has been reset successfully!',
            html: '<p>You can now login with your new password.</p>'
          }).then(() => {
            this.newPassword = ''
            this.confirmPassword = ''

            // this.$router.push('/login')
          })
        })

        .catch(error => {
          if (error.response.status === 422) {
            // this.dialog = true;
            console.log(error.response.status)
            this.confirmPasswordRule = ['The password field confirmation does not match']
          } else {
            console.log('Unknown error occurred:', error)
          }
        })
    }
  },
  created() {
    this.token = this.$route.params.token
  },
  computed: {
    isPasswordValid() {
      return this.newPassword.length >= 8
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

<style scoped>
@import '~vuetify/dist/vuetify.css';

.alter {
  margin-bottom: 150%;
}
</style>

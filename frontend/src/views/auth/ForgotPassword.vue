<template>
  <v-layout class="d-flex justify-center align-center" style="height: 100vh">
    <v-snackbar location="top" v-model="snackbarVisible" color="success">
      Password reset email sent successfully!
      <span>Please check your email {{ this.email }}</span>
    </v-snackbar>
    <v-container class="d-flex justify-center align-center">
      <v-col>
        <v-img src="../../../public/images/forget_password.jpeg" max-width="500"> </v-img>
      </v-col>
      <v-col>
        <h4>Forgot password</h4>
        <span>Enter your email to reset your password.</span>
        <v-card elevation="0" width="400" class="mt-5">
          <v-form ref="form" @submit.prevent="getLinkResetPass">
            <v-card-text class="px-0">
              <v-text-field
                ref="emailField"
                label="Email"
                prepend-inner-icon="mdi-email-outline"
                v-model="email"
                :rules="emailRules"
                variant="outlined"
                no-validation
              ></v-text-field>
              <span :rules="emailRules[0]"></span>
            </v-card-text>
            <v-card-actions class="px-0">
              <v-spacer></v-spacer>
              <v-btn to="/login" color="teal-darken-4" variant="outlined">Cancel</v-btn>
              <v-btn type="submit" class="bg-teal-darken-4">Continue</v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-col>
    </v-container>
  </v-layout>
</template>

<script>
import { useAuthStore } from '@/stores/auth'
import { mapActions } from 'pinia'

export default {
  data: () => ({
    visible: false,
    snackbarVisible: false,
    overlay: false,
    email: 'phloeutnong@gmail.com',
    emailRules: [
      v => !!v || 'E-mail is required',
      v => /.+@.+\..+/.test(v) || 'E-mail must be valid'
    ]
  }),

  methods: {
    ...mapActions(useAuthStore, ['forgotPassword']),
    getLinkResetPass() {
      this.forgotPassword(this.email)
        .then(response => {
          this.$root.$notif('Reset Password successfully', {
              type: 'success',
              color: 'primary'
            })
          console.log(response)
        })
        .catch(error => {
          if (error.response.status === 404) {
            if (this.emailRules !== '') {
              this.overlay = false
            }
          } else {
            console.log(error)
          }
        })
    }
  }
}
</script>

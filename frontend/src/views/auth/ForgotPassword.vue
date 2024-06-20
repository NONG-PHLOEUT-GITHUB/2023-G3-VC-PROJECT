<template>
  <v-layout class="d-flex justify-center align-center bg-background" height="100vh">
    <v-col class="d-flex justify-end d-none d-print-block">
      <v-img src="images/forget-password.png" max-width="500"> </v-img>
    </v-col>
    <v-col>
      <h2>Forgot password</h2>
      <v-col cols="8" class="pa-0 mt-15">
        <span>Enter your email to reset your password.</span>
          <v-form ref="form" @submit.prevent="getLinkResetPass">
            <v-card-text class="px-0">
              <v-text-field
              ref="emailField"
              label="Email"
              prepend-inner-icon="mdi-email-outline"
              v-model="email"
              :rules="emailRules"
              :error-messages="emailError"
              variant="outlined"
              no-validation
              color="textField"
              ></v-text-field>
            </v-card-text>
            <v-card-actions class="px-0">
              <v-spacer></v-spacer>
              <v-btn to="/login" color="teal-darken-4" variant="outlined">Cancel</v-btn>
              <v-btn type="submit" class="bg-teal-darken-4">Continue</v-btn>
            </v-card-actions>
          </v-form>
        </v-col>
    </v-col>
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
    ],
    emailError: ''
  }),

  methods: {
    ...mapActions(useAuthStore, ['forgotPassword']),
    getLinkResetPass() {
      this.forgotPassword(this.email)
        .then(() => {
          this.$root.$notif('Reset Password successfully', {
            type: 'success',
            color: 'primary'
          })
        })
        .catch(error => {
          if (error.response.status === 404) {
            this.emailError = "Email doesn't exists."
            this.emailRules !== ''
          } else if (error.response.status === 500) {
            this.$root.$notif(error.response.data.message, {
              type: 'info',
              color: 'info'
            })
          }
        })
    }
  }
}
</script>

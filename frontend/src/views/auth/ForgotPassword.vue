<template>
  <v-layout class="d-flex justify-center align-center" style="height: 100vh">
    <v-snackbar location="top" v-model="snackbarVisible" color="success">
      Password reset email sent successfully!
      <span>Please check your email {{ this.email }}</span>
    </v-snackbar>
    <v-container class="d-flex justify-center align-center">
      <v-col>
        <v-img
          src="https://static.vecteezy.com/system/resources/previews/005/879/539/original/cloud-computing-modern-flat-concept-for-web-banner-design-man-enters-password-and-login-to-access-cloud-storage-for-uploading-and-processing-files-illustration-with-isolated-people-scene-free-vector.jpg"
          max-width="500"
        >
        </v-img>
      </v-col>
      <v-col>
        <h4>Forgot password</h4>
        <span>Enter your email to reset your password</span>
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
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn to="/login" color="teal-darken-4" variant="outlined">Cancel</v-btn>
              <v-btn type="submit" class="bg-teal-darken-4">Next</v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-col>
    </v-container>
  </v-layout>
</template>

<script>
import http from '@/api/api'
import { useAuthStore } from '@/stores/auth'
//  https://vee-validate.logaretm.com/v4/tutorials/basics/
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
    ...mapActions(useAuthStore,['forgotPassword']),
    getLinkResetPass() {
      this.forgotPassword(this.email).then(response=>{
        console.log(response);
        // if(response.data === 404){

        // }
        // //           this.emailRules = ['Email not found']
        // console.log(response);
      })
      // if (this.$refs.form.validate() && this.email && this.emailRules) {
      //   this.overlay = true

      //   http
      //     .post('auth/forgot-password', {
      //       email: this.email
      //     })
      //     .then(() => {
      //       this.snackbarVisible = true
      //       this.overlay = false
      //     })
      //     .catch(error => {
      //       if (error.response.status === 404) {
      //         if (this.emailRules !== '') {
      //           this.overlay = false
      //         }
      //       } else {
      //         console.log(error)
      //       }
      //     })
      // }
    }
  }
}
</script>

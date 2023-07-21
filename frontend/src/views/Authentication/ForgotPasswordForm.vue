<template>
  <!-- <div class="d-flex justify-center">
    <v-alert  v-if="isSuccess" type="success" icon="mdi-checkbox-marked-circle" class="alter">
        Please check your email <a :href="'mailto:' + email" target="_blank">{{ email }}</a>
    </v-alert>
  </div> -->

  <v-layout class="d-flex  justify-center align-center " style="height: 100vh;">
      <v-container class="d-flex  justify-center align-center">

          <v-flex xs12 md6 class="mb-7 w-50">
              <v-img
                  src="https://static.vecteezy.com/system/resources/previews/005/879/539/original/cloud-computing-modern-flat-concept-for-web-banner-design-man-enters-password-and-login-to-access-cloud-storage-for-uploading-and-processing-files-illustration-with-isolated-people-scene-free-vector.jpg"
                  max-width="500">
              </v-img>
          </v-flex>
          <v-flex xs14 md6>

              <v-card width="500" class="mx-auto border--5 mx-auto pa-12 pb-8 mt-9" elevation="10" max-width="448"
                  rounded="lg">
                  <v-form ref="form" @submit.prevent="forgotPassword">
                      <h2>Forgot password</h2>
                      <div class="text-subtitle-1 text-medium-emphasis mt-8">Email</div>

                      <v-text-field ref="emailField" density="compact" placeholder="Email address"
                          prepend-inner-icon="mdi-email-outline" v-model="email" :rules="emailRules" variant="outlined"
                          no-validation></v-text-field>
                      <span :rules="emailRules[0]"></span>
                      <v-row no-gutters>
                          <v-col>
                              <v-btn to="/" class="text-none mt-4" color="blue-darken-4" block
                                  variant="outlined">Cancel</v-btn>
                          </v-col>
                          <v-col>
                              <v-btn ref="button" type="submit" color="primary" block class="mt-4 ms-1">Next</v-btn>
                          </v-col>
                      </v-row>

                  </v-form>
              </v-card>
          </v-flex>
      </v-container>
  </v-layout>
</template>



<script>

import http from '@/htpp.common';
// recferences// https://vee-validate.logaretm.com/v4/tutorials/basics/

export default {
  data: () => ({
      visible: false,
      email: '',
      emailRules: [
          v => !!v || 'E-mail is required',
          v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
  }),

  methods: {
      forgotPassword() {
          if (this.$refs.form.validate()) {
              http.post('/api/forgot-password', {
                  email: this.email,
              })
              .then(() => {
                  this.email = "";
              })
              .catch(error => {
                  if (error.response.status === 404) {
                      if (this.emailRules !== '') {
                          this.emailRules = ['Email not found'];
                      }

                  } else {
                      console.log(error);
                  }
              });
          }
      },
  }

}
</script>
<style>
@import "~vuetify/dist/vuetify.css";

</style>


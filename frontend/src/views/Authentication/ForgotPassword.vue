<template>
  <v-layout class="d-flex  justify-center align-center " style="height: 100vh;">
    <v-container class="d-flex  justify-center align-center">

      <v-flex xs12 md6 class="mb-7 w-50">
        <v-title class="text-subtitle-1">
          Enter the email address associated with your account.
          Click on the "Next" button.
          We will send you an email with instructions on how to reset your password.
          Follow the instructions in the email to reset your password.
        </v-title>
        <v-img
          src="https://static.vecteezy.com/system/resources/previews/005/879/539/original/cloud-computing-modern-flat-concept-for-web-banner-design-man-enters-password-and-login-to-access-cloud-storage-for-uploading-and-processing-files-illustration-with-isolated-people-scene-free-vector.jpg"
          max-width="500">
        </v-img>
      </v-flex>
      <v-flex xs14 md6>

        <v-card width="500" class="mx-auto border--5 mx-auto pa-12 pb-8 mt-9" elevation="10" max-width="448" rounded="lg">
          <v-form ref="form" @submit.prevent="login">
            <v-title class="text-h6 text-md-h5 text-lg-h4 text-center">
              Forgot Password
            </v-title>
            <div class="text-subtitle-1 text-medium-emphasis mt-8">Email</div>

            <v-text-field ref="emailField" density="compact" placeholder="Email address"
              prepend-inner-icon="mdi-email-outline" v-model="email" :rules="emailRules" variant="outlined"
              no-validation></v-text-field>
            <span :rules="emailRules"></span>
            <v-row no-gutters>
              <v-col>
                <v-btn class="text-none mt-4" color="blue-darken-4" block variant="outlined">Cancel</v-btn>
              </v-col>
              <v-col>
                <v-btn type="submit" color="primary" block class="mt-4 ms-1">Next</v-btn>
              </v-col>
            </v-row>

          </v-form>
        </v-card>
      </v-flex>
    </v-container>
  </v-layout>
</template>



<script>
// import Swal from 'sweetalert2'
import http from '../../htpp.common';
// recferences// https://vee-validate.logaretm.com/v4/tutorials/basics/

export default {
  emits: ['isLogin'],
  data: () => ({
    visible: false,
    loading: false,
    snackbar: false,
    passwordShow: false,
    email: '',
    password: '',
    emailRules: [
      // v => !!v  'E-mail is required',
      // v => /.+@.+\..+/.test(v)  'E-mail must be valid',
    ],
    passwordRules: [
      // v => !!v  'Password is required',
      // v => (v && v.length >= 6)  'Password must be 6  characters or more!',
    ],
  }),

  methods: {
    login() {
      if (this.$refs.form.validate()) {
        http.post('/api/login', {
          email: this.email,
          password: this.password,
        })
          .then(response => {
            console.log('API response:', response.data.token);
            localStorage.setItem('access_token', response.data.token);
            // alert('login successful');
            // Swal.fire({
            //     position: 'top-end',
            //     icon: 'success',
            //     title: 'Login successfully',
            //     showConfirmButton: false,
            //     timer: 1500
            // })
          }).then(() => {
            sessionStorage.setItem('email', this.email);
            this.$emit('isLogin', true, this.email);
            this.$router.push('/home');
          })
          .catch(error => {
            if (error.response.status === 401) {
              if (this.emailRules !== '' && this.password !== '' && this.passwordRules !== '' && this.passwordRules !== '') {
                this.emailRules = ['Email or password is icorrect'];
                this.passwordRules = ['Email or password is icorrect'];
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
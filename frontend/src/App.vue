<template>
  <main>

    <template v-if="isLogged">
      <dashboard-view @isLogin="handleLogin" @isChangePassword="handleChangePassword('save')">
        <router-view></router-view>
        <v-row justify="center">
          <v-dialog v-model="dialog" persistent width="1024">
            <formchange-password @isCancelChangePassword="handleChangePassword('cancel')"></formchange-password>
          </v-dialog>
        </v-row>
      </dashboard-view>
    </template>

    <template v-else-if="forgotPassword">
      <form-forgot-password @isCancel="cancelForgotPassword" @isSubmit="submitForgotPassword"></form-forgot-password>
    </template>

    <template v-else-if="resetPassword">
      <form-reset-password @isResetPassword="handleResetPassword">
      </form-reset-password>
    </template>

    <template v-else>
      <form-login @isLogin="handleLogin" @isForgotPassword="handleforgotPassword"></form-login>
    </template>

  </main>
</template>

<script>
import FormLogin from './views/Authentication/LoginView2.vue';
import FormForgotPassword from './views/Authentication/ForgotPassword.vue';
import FormResetPassword from './views/Authentication/ResetNewPassword.vue';
import DashboardView from './components/Navigation/DashboardView.vue';
import FormchangePassword from './views/Authentication/ChangePassword.vue';

export default {
  components: {
    DashboardView,
    FormLogin,
    FormForgotPassword,
    FormResetPassword,
    FormchangePassword,
  },

  data: () => ({
    isLogged: false,
    userEmail: null,
    forgotPassword: false,
    resetPassword: false,
    forgotPasswordEmail: null,
    isHasChanged: false,
    dialog: false,
  }),
  created() {
    const email = sessionStorage.getItem('email');
    if (email !== null) {
      this.isLogged = true;
      this.userEmail = email;
      console.log(this.userEmail);
    }
    this.handleResetPassword();
  },


  methods: {
    handleLogin(isLogged, email) {
      this.isLogged = isLogged;
      this.userEmail = email;
    },

    handleforgotPassword() {
      this.forgotPassword = true;
      console.log(this.forgotPassword);
    },

    cancelForgotPassword() {
      this.forgotPassword = false;
    },

    submitForgotPassword(email) {
      this.forgotPasswordEmail = email;
      alert(`An email has been sent to ${email} with instructions on how to reset your password.`);
      this.forgotPassword = false;
      this.resetPassword = true;
    },

    // handleResetPassword() {
    //   this.resetPassword = false;
    //   this.isLogged = true;
    // },
    handleResetPassword() {
      console.log('URL:', window.location.href);
      const searchParams = new URLSearchParams(window.location.search);
      if (searchParams.has('reset_new_password')) {
        this.resetPassword = true;
        const resetToken = searchParams.get('reset_new_password');
        console.log('Reset token:', resetToken);
      } else {
        this.resetPassword = false;
      }
      console.log('Reset password:', this.resetPassword);
    },

    handleChangePassword(isActive) {
      if (isActive == 'save') {
        this.dialog = true;
      }else if (isActive == 'cancel') {
        console.log(isActive);
        this.dialog = false;
      }
      else{
        this.dialog = false;
      }
      
    },

  },
}

</script>

<style>
/* main{
  background: #c1afaf;
} */
@import url(https://unpkg.com/@webpixels/css@1.1.5/dist/index.css);

/* Bootstrap Icons */
@import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");
</style>

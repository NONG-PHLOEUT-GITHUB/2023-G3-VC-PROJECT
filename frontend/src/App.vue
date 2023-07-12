<template>
  <main>
    <template v-if="isLogged">
      <dashboard-view @isLogin="handleLogin">
        <router-view></router-view>
      </dashboard-view>
    </template>
    <template v-else-if="forgotPassword">
      <form-forgot-password></form-forgot-password>
    </template>
    <!-- <template v-else-if="resetPassword">
      <form-reset-password @isResetPassword="handleResetPassword"></form-reset-password>
    </template> -->
    <template v-else>
      <form-login @isLogin="handleLogin" @isForgotPassword="handleforgotPassword"></form-login>
    </template>
  </main>
</template>

<script>
import FormLogin from './views/Authentication/LoginView2.vue';
import FormForgotPassword from './views/Authentication/ForgotPassword.vue';
// import FormResetPassword from './views/Authentication/ResetNewPassword.vue';
import DashboardView from './components/Navigation/DashboardView.vue';

export default {
  components: {
    DashboardView,
    FormLogin,
    FormForgotPassword,
    // FormResetPassword
  },

  data: () => ({
      isLogged:false,
      userEmail: null,
      forgotPassword:false,
      resetPassword: false,
  }),
  created() {
    const email = sessionStorage.getItem('email');
    if (email !== null) {
      this.isLogged = true;
      this.userEmail = email;
      console.log(this.userEmail);
    }
  },


  methods: {
    handleLogin(isLogged,email) {
      this.isLogged = isLogged;
      this.userEmail = email;
    },

    handleforgotPassword(){
      this.forgotPassword = true;
      console.log(this.forgotPassword);
    },
    // handleResetPassword(){
    //   this.resetPassword = true;
    //   this.forgotPassword = false;
    //   console.log(this.forgotPassword);
    // }
  }
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

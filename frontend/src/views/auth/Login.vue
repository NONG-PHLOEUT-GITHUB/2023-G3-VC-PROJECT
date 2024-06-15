<template>
  <v-layout class="login">
    <v-app-bar collapse :elevation="2">
      <switcher-language />
    </v-app-bar>
    <v-card width="60%" class="py-0">
      <v-row>
        <v-col cols="6">
          <v-img
            :width="458"
            class="login-image"
            aspect-ratio="1"
            src="https://media.istockphoto.com/id/1281150061/vector/register-account-submit-access-login-password-username-internet-online-website-concept.jpg?s=612x612&w=0&k=20&c=9HWSuA9IaU4o-CK6fALBS5eaO1ubnsM08EOYwgbwGBo="
            cover
          ></v-img>
        </v-col>
        <v-col cols="6" class="px-8">
          <v-card-title class="px-0">
            <h3>{{ $t('login.title') }}</h3>
          </v-card-title>
          <v-form ref="form" class="mt-5" @submit.prevent="connection">
            <v-text-field
              :label="$t('login.lebelEmail')"
              ref="emailField"
              prepend-inner-icon="mdi-email-outline"
              v-model="email"
              :rules="emailRules"
              variant="outlined"
              no-validation
              :error-messages="incorrect"
            ></v-text-field>
            <v-text-field
              :label="$t('login.lebelPass')"
              :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
              :type="visible ? 'text' : 'password'"
              prepend-inner-icon="mdi-lock-outline"
              v-model="password"
              :rules="passwordRules"
              variant="outlined"
              @click:append-inner="visible = !visible"
              :error-messages="incorrect"
              class="mt-4 mb-2"
            ></v-text-field>
            <router-link to="/forgot-password">
              {{ $t('login.form.forgot-pass') }}
            </router-link>
            <v-btn
              type="submit"
              color="teal darken-4 mt-7"
              block
              class="login-button"
            >
              {{ $t('btn.login') }}
            </v-btn>
          </v-form>
        </v-col>
      </v-row>
    </v-card>
  </v-layout>
</template>
<script>
  import { mapActions } from 'pinia'
  import { useAuthStore } from '@/stores/auth'
  import SwitcherLanguage from '@/components/common/SwitcherLanguage.vue'
  export default {
    components: {
      SwitcherLanguage
    },
    data: () => ({
      visible: false,
      email: 'admin@example.com',
      password: 'admin1234',
      emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid'
      ],
      passwordRules: [
        v => !!v || 'Password is required',
        v => (v && v.length >= 8) || 'Password must be 8  characters or more!'
      ],
      incorrect: ''
    }),

    methods: {
      ...mapActions(useAuthStore, ['login']),
      connection() {
        if (this.$refs.form.validate()) {
          this.login({ email: this.email, password: this.password })
            .then(response => {
              this.$root.$notif('Login successfully', {
                type: 'success',
                color: 'primary'
              })
              const userRole = response.data.user.role
              if (userRole === 1) {
                this.$router.push('/admin-dashboard')
              } else if (userRole === 2) {
                this.$router.push('/teacher-dashboard')
              } else {
                this.$router.push('/student-home')
              }
            })
            .catch(error => {
              if (error.response.status === 401) {
                this.incorrect = 'Email or password is incorrect'
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
  }
</script>
<style scoped>
  .login {
    display: flex;
    justify-content: center;
    align-items: center;
  }
</style>

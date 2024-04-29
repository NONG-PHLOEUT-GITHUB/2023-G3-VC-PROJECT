<script>
import { mapActions } from 'pinia'
import { useAuthStore } from '@/stores/auth'
export default {
  data: () => ({
    visible: false,
    passwordShow: false,
    email: 'phloeutnong@gmail.com',
    password: 'Jbemg2CC',
    emailRules: [
      v => !!v || 'E-mail is required',
      v => /.+@.+\..+/.test(v) || 'E-mail must be valid'
    ],
    passwordRules: [
      v => !!v || 'Password is required',
      v => (v && v.length >= 8) || 'Password must be 8  characters or more!'
    ]
  }),

  methods: {
    ...mapActions(useAuthStore, ['login']),
    connection() {
      if (this.$refs.form.validate()) {
        this.login({ email: this.email, password: this.password })
          .then(response => {
            // console.log('res',response)
            if (response) {
              this.$router.push('/student-home')
            }
          })
          .catch(error => {
            if (error.response && error.response.status === 401) {
              if (
                this.email != '' &&
                this.password != '' &&
                this.emailRules != '' &&
                this.passwordRules != ''
              ) {
                this.emailRules = ['']
                this.passwordRules = ['Email or password is incorrect']
                console.log('email role', this.emailRules)
              }
            } else {
              console.log(error)
            }
          })
      }
    }
  }
}
</script>

<template>
  <div class="login-page">
    <div class="login-container">
      <div class="login-content">
        <h1 class="logo">SCHOOL MANAGEMENT</h1>
        <!-- src="../../../public/assets/images/Mobilelogin.png" -->
        <v-img
          class="login-image"
          aspect-ratio="1"
          src="https://media.istockphoto.com/id/1281150061/vector/register-account-submit-access-login-password-username-internet-online-website-concept.jpg?s=612x612&w=0&k=20&c=9HWSuA9IaU4o-CK6fALBS5eaO1ubnsM08EOYwgbwGBo="
          cover
        ></v-img>
      </div>
      <v-card class="login-card">
        <v-form ref="form" @submit.prevent="connection">
          <h1 class="login-title">Login</h1>
          <div class="input-group">
            <!-- density="compact" -->
            <v-text-field
              label="Email"
              ref="emailField"
              prepend-inner-icon="mdi-email-outline"
              v-model="email"
              :rules="emailRules"
              variant="outlined"
              no-validation
            ></v-text-field>
            <!-- <span :rules="emailRules"></span> -->
          </div>
          <div class="input-group">
            <!-- density="compact" -->
            <v-text-field
              label="Password"
              :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
              :type="visible ? 'text' : 'password'"
              prepend-inner-icon="mdi-lock-outline"
              v-model="password"
              :rules="passwordRules"
              variant="outlined"
              @click:append-inner="visible = !visible"
            ></v-text-field>
            <!-- <v-card
              v-if="errorText"
              class="mx-auto pa-1"
              variant="tonal"
              color="red"
            >
              <span>{{ errorText }}</span>
            </v-card>
            <v-card v-else class="mx-auto pa-1" variant="flat" color="#f4f4f4">
              <span class="error">.</span>
            </v-card> -->
          </div>

          <router-link to="/forgot-password">Forgot login password ?</router-link>
          <v-btn type="submit" color="teal darken-4" block class="login-button">Login</v-btn>
          <!-- {{ $t('login.title') }} -->
        </v-form>
      </v-card>
    </div>
  </div>
</template>

<style scoped>
.login-page {
  background: #f4f4f4;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.login-container {
  display: flex;
  background: white;
  border-radius: 10px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  max-width: 1200px;
  width: 100%;
}

.login-content {
  flex: 1;
  padding: 2rem;
}

.logo {
  font-size: 2rem;
  color: #333;
}

.login-image {
  margin-top: 2rem;
}

.login-card {
  flex: 1;
  padding: 2rem;
  background: #f5f5f5;
  border-left: 1px solid #e0e0e0;
}

.login-title {
  font-size: 2rem;
  margin-bottom: 1rem;
  color: #333;
}

.input-group {
  margin: 1.5rem 0;
}

.input-label {
  font-size: 1.2rem;
  color: #666;
}

.forgot-password-link {
  font-size: 1rem;
  color: #666;
  text-decoration: none;
  display: block;
  margin-top: -15px;
}

.login-button {
  margin-top: 2rem;
}
.error {
  color: #f5f5f5;
}
</style>

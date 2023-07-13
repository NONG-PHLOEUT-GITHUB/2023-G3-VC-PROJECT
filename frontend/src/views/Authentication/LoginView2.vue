<template>
    <div class="container d-flex align-center justify-center" style="height: 100vh;">
        <div class="ma-4">
            <h2>SCHOOL MANAGEMENT</h2>
            <v-img class="bg-white" width="300" :aspect-ratio="1"
                src="https://media.istockphoto.com/id/1281150061/vector/register-account-submit-access-login-password-username-internet-online-website-concept.jpg?s=612x612&w=0&k=20&c=9HWSuA9IaU4o-CK6fALBS5eaO1ubnsM08EOYwgbwGBo="
                cover></v-img>
        </div>
        <v-card width="500" class="mx-auto border--5 mx-auto pa-12 pb-8" elevation="10" max-width="448" rounded="lg">
            <v-form ref="form" @submit.prevent="login">
                <v-title>
                    <h1>Login</h1>
                </v-title>
                <div class="text-subtitle-1 text-medium-emphasis mt-8">Email</div>

                <v-text-field ref="emailField" density="compact" placeholder="Email address"
                    prepend-inner-icon="mdi-email-outline" v-model="email" :rules="emailRules" variant="outlined"
                    no-validation></v-text-field>
                <span :rules="emailRules"></span>
                <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">Password</div>

                <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'" :type="visible ? 'text' : 'password'"
                    density="compact" placeholder="Enter your password" prepend-inner-icon="mdi-lock-outline"
                    v-model="password" :rules="passwordRules" variant="outlined"
                    @click:append-inner="visible = !visible"></v-text-field>

                <router-link @click="forgotPassword" :to="{ path: '/forgot_password' }">Forgot login password?</router-link>

                <v-btn type="submit" color="primary" block class="mt-4">login</v-btn>
            </v-form>
        </v-card>
    </div>
</template>
  


<script>
import Swal from 'sweetalert2'
import http from '../../htpp.common';
// import { sha256 } from 'js-sha256';
// recferences// https://vee-validate.logaretm.com/v4/tutorials/basics/
export default {

    emits: ['isLogin', 'isForgotPassword'],
    data: () => ({
        visible: false,
        loading: false,
        snackbar: false,
        passwordShow: false,
        email: '',
        password: '',
        emailRules: [
            v => !!v || 'E-mail is required',
            v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
        ],
        passwordRules: [
            v => !!v || 'Password is required',
            v => (v && v.length >= 6) || 'Password must be 6  characters or more!',
        ],
    }),

    methods: {
        login() {
            if (this.$refs.form.validate()) {
                http.post('/api/v1/auth/login', {
                    email: this.email,
                    password: this.password,
                })
                    .then(response => {
                        console.log('API response:', response.data);
                        localStorage.setItem('access_token', response.data.access_token);
                        // alert
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 500,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Signed in successfully'
                        }) 
                        // sessionStorage.setItem('email', this.email);
                        // this.$emit('isLogin', true, this.email);
                    })
                    .then(() => {
                        // const value = this.email;

                        // // Hash the value using SHA-256
                        // const hashedValue = sha256(value);

                        // // Store the hashed value in local storage
                        // localStorage.setItem('email', hashedValue);

                        sessionStorage.setItem('email', this.email);
                        this.$emit('isLogin', true, this.email);
                        this.$router.push('/home');
                    })
                    .catch(error => {
                        if (error.response.status === 401) {
                            if (this.emailRules !== '' && this.password !== '' && this.passwordRules !== '' && this.passwordRules !== '') {
                                this.emailRules = [''];
                                this.passwordRules = ['Email or password is incorrect'];
                            }

                        } else {
                            console.log(error);
                        }
                    });
            }
        },

        forgotPassword() {
            this.$emit('isForgotPassword', true);
        }
    }

}
</script>
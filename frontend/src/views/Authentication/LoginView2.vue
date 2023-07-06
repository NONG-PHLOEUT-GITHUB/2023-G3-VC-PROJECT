<template>
    <div class="container d-flex align-center justify-center" style="height: 100vh;">
        <!-- <div class="w-800" style="background-color: rgb(203, 187, 12);">
            <v-img
                src="https://static.vecteezy.com/system/resources/previews/005/879/539/original/cloud-computing-modern-flat-concept-for-web-banner-design-man-enters-password-and-login-to-access-cloud-storage-for-uploading-and-processing-files-illustration-with-isolated-people-scene-free-vector.jpg"
                width="100" height="300" contain>
            </v-img>
        </div> -->
        <v-card width="500" class="mx-auto border--5 mx-auto pa-12 pb-8" elevation="10" max-width="448" rounded="lg">
            <v-form ref="form" @submit.prevent="login" >
                <v-title>
                    <h1>Login</h1>
                </v-title>
                <div class="text-subtitle-1 text-medium-emphasis mt-8">Email</div>

                <v-text-field 
                    ref="emailField" 
                    density="compact" 
                    placeholder="Email address" 
                    prepend-inner-icon="mdi-email-outline"
                    v-model="email" :rules="emailRules"
                    variant="outlined" 
                    no-validation
                ></v-text-field>
                <span :rules="emailRules"></span>
                <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">Password</div>

                <v-text-field 
                :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'" 
                :type="visible ? 'text' : 'password'"
                density="compact" placeholder="Enter your password" prepend-inner-icon="mdi-lock-outline"
                v-model="password" :rules="passwordRules"
                variant="outlined" @click:append-inner="visible = !visible"></v-text-field>

                <a class="text-caption text-decoration-none text-blue mt-0" href="#" rel="noopener noreferrer"
                    target="_blank">Forgot login password?</a>

                <v-btn type="submit" color="primary" block class="mt-4">login</v-btn>
            </v-form>
        </v-card>
    </div>
</template>
  


<script>

import http from '../../htpp.common';
// recferences// https://vee-validate.logaretm.com/v4/tutorials/basics/

export default {
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
                http.post('/api/login', {
                    email: this.email,
                    password: this.password,
                })
                    .then(response => {
                        console.log('API response:', response.data.token);
                        sessionStorage.setItem('email', this.email);
                        localStorage.setItem('access_token', response.data.token);
                        this.$router.push('/student');
                        alert('login successful');
                    })
                    .catch(error => {
                        if (error.response.status === 401) {
                            if (this.emailRules !== '' && this.password !== '' && this.passwordRules !== '' && this.passwordRules !== '')
                            {
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
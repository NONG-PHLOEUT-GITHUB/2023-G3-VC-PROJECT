<template>
    <div class="container d-flex align-center justify-center" style="height: 100vh">
        <v-img
            src="https://static.vecteezy.com/system/resources/previews/005/879/539/original/cloud-computing-modern-flat-concept-for-web-banner-design-man-enters-password-and-login-to-access-cloud-storage-for-uploading-and-processing-files-illustration-with-isolated-people-scene-free-vector.jpg"
            alt="Image description" width="500" height="300" contain></v-img>
        <v-sheet width="500" class="mx-auto border--5" elevation="10">
            <v-row>
                <v-col cols="12">
                    <h2 class="mb-10">LOGIN</h2>
                </v-col>
            </v-row>
            <v-form ref="form" @submit.prevent="login">
                <v-text-field ref="emailField" variant="outlined" v-model="email" :rules="emailRules" type="email"
                    label="Email" placeholder="Email" prepend-inner-icon="mdi-account" required />
                <span :rules="emailRules"></span>

                <v-text-field ref="passwordField" class="mt-4" variant="outlined" v-model="password" :rules="passwordRules"
                    :type="passwordShow ? 'text' : 'password'" label="Password" placeholder="Password"
                    prepend-inner-icon="mdi-key" required :append-inner-icon="passwordShow ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append="passwordShow = !passwordShow" :append-icon-cb="null"
                    @click:append-inner="togglePasswordVisibility" />
                <a href="#" class="text-body-2 font-weight-regular">Forgot Password?</a>

                <v-btn type="submit" color="primary" block class="mt-4">login</v-btn>

            </v-form>
        </v-sheet>
    </div>
</template>
<script>

import http from '../../htpp.common';
// recferences// https://vee-validate.logaretm.com/v4/tutorials/basics/

export default {
    data: () => ({
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
                        localStorage.setItem('access_token', response.data.token);
                        this.$router.push('/student');
                        // alert('login successful');
                    })
                    .catch(error => {
                        if (error.response.status === 401) {
                            if(this.emailRules !== ''  && this.password !== '' && this.passwordRules !== '' && this.passwordRules !== '')  
                            // if(this.email == ''){
                            //     this.emailRules = ['email or password'];
                            // }else 
                            {
                                this.emailRules = ['Email or password is icorrect'];
                                this.passwordRules = ['Email or password is icorrect']; 
                            }
                            // else if(!this.emailRules){
                            //         this.emailRules = ['email or password'];
                            // }
                       
                        } else {
                            console.log(error);
                        }
                    });
            }
        },

        togglePasswordVisibility() {
            this.passwordShow = !this.passwordShow;
        },
    }

}
</script>
<style>
.container {
    padding: 20px;
}

.mx-auto {
    padding: 20px;
}

h2 {
    margin-bottom: 20%;
}
</style>
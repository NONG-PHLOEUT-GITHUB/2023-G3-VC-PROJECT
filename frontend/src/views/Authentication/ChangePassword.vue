<template>
    <div class="container d-flex align-center justify-center" style="height: 100vh;">
        <div class="ma-4">
            <h2>SCHOOL MANAGEMENT</h2>
            <v-img class="bg-white" width="300" :aspect-ratio="1"
                src="https://img.freepik.com/free-vector/key-concept-illustration_114360-6305.jpg?w=740&t=st=1688968989~exp=1688969589~hmac=3df727a833bf7fda300b7187397feb313d8ae5e060a5cec4ccf7c3f3e6872185"
                cover></v-img>
        </div>
        <v-card width="500" class="mx-auto border--5 mx-auto pa-12 pb-8" elevation="10" max-width="448" rounded="lg">
            <v-form ref="form" @submit.prevent="changePassword">
                <v-title>
                    <h1>Change password</h1>
                </v-title>
                <div class="text-subtitle-1 text-medium-emphasis mt-8">
                    Current password
                </div>

                <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'" :type="visible ? 'text' : 'password'"
                    density="compact" placeholder="Enter current password" prepend-inner-icon="mdi-lock-outline"
                    v-model="currentPassword" :rules="passwordRules" variant="outlined"
                    @click:append-inner="visible = !visible">
                </v-text-field>
                <span :rules="emailRules"></span>

                <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
                    New password
                </div>

                <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'" :type="visible ? 'text' : 'password'"
                    density="compact" placeholder="Enter your new password" prepend-inner-icon="mdi-lock-outline"
                    v-model="newPassword" :rules="passwordRules" variant="outlined"
                    @click:append-inner="visible = !visible">
                </v-text-field>

                <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
                    Confirm new password
                </div>
                <v-text-field :append-inner-icon="visibleConfirm ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="visibleConfirm ? 'text' : 'password'" density="compact"
                    placeholder="Enter your confirm new password" prepend-inner-icon="mdi-lock-outline"
                    v-model="confirmPassword" :rules="NewPasswordRules" variant="outlined"
                    @click:append-inner="visibleConfirm = !visibleConfirm">
                </v-text-field>

                <v-btn type="submit" color="primary" block class="mt-4">Change Password</v-btn>
            </v-form>
            <div v-if="successMessage">{{ successMessage }}</div>
            <div v-if="errorMessage">{{ errorMessage }}</div>
        </v-card>
    </div>
</template>
  


<!--recferences// https://vee-validate.logaretm.com/v4/tutorials/basics/ -->
<script>
// import Swal from 'sweetalert2'

import http from '../../htpp.common';
export default {
    data() {
        return {
            visible: false,
            visibleConfirm: false,
            passwordShow: false,

            currentPassword: '',
            newPassword: '',
            confirmPassword: '',
            successMessage: '',
            errorMessage: '',

            emailRules: [
                v => !!v || 'New password is required',
                v => (v && v.length >= 6) || 'Password must be 6  characters or more!',
            ],
            passwordRules: [
                v => !!v || 'New password is required',
                v => (v && v.length >= 6) || 'Password must be 6  characters or more!',
            ],
            NewPasswordRules: [
                v => !!v || 'Confirm new password is required',
                v => (v && v.length >= 6) || 'Password must be 6  characters or more!',
            ],
        };
    },
    methods: {
        changePassword() {
            const data = {
                current_password: this.currentPassword,
                new_password: this.newPassword,
                new_password_confirmation: this.confirmPassword,
            };
            http.post('/api/password/change', data, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('access_token')}`,
                },
            })
                .then(response => {
                    this.successMessage = response.data.message;
                    this.errorMessage = '';
                    this.currentPassword = '';
                    this.newPassword = '';
                    this.confirmPassword = '';
                    console.log(this.successMessage);
                })
                .catch(error => {
                    this.errorMessage = error.response.data.error;
                    this.successMessage = '';
                    if (error.response.status === 401) {
                        if (this.emailRules !== '' && this.password !== '' && this.passwordRules !== '' && this.passwordRules !== '') {
                            this.emailRules = ['Email or password is icorrect'];
                            this.passwordRules = ['Email or password is icorrect'];
                        }

                    } else {
                        console.log(error);
                    }
                });
        },
    },
};
</script>
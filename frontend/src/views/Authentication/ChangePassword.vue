<template>
    <div class="container d-flex align-center justify-center" style="height: 100vh;">
        <v-card width="500" class="mx-auto border--5 mx-auto pa-12 pb-8" elevation="10" max-width="448" rounded="lg">
            <v-form ref="form" @submit.prevent="changePassword">
                <v-title>
                    <h1>Change password</h1>
                </v-title>
                <div class="text-subtitle-1 text-medium-emphasis mt-8">
                    Current password
                </div>

                <v-text-field :append-inner-icon="visibleCurrent ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="visibleCurrent ? 'text' : 'password'" density="compact" placeholder="Enter current password"
                    prepend-inner-icon="mdi-lock-outline" v-model="currentPassword" :rules="passwordRules"
                    variant="outlined" @click:append-inner="visibleCurrent = !visibleCurrent">
                </v-text-field>
                <span :rules="emailRules"></span>

                <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
                    New password
                </div>

                <v-text-field :append-inner-icon="visibleNew ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="visibleNew ? 'text' : 'password'" density="compact" placeholder="Enter your new password"
                    prepend-inner-icon="mdi-lock-outline" v-model="newPassword" :rules="passwordRules" variant="outlined"
                    @click:append-inner="visibleNew = !visibleNew">
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

                <v-row no-gutters>
                    <v-col>
                        <v-btn @Click="cancelChangePassword" class="text-none mt-4 w-25" color="blue-darken-4" block 
                            variant="outlined">Cancel</v-btn>
                    </v-col>
                    <v-col>
                        <v-btn type="submit" color="primary" block class="mt-4 ms-1">Save</v-btn>
                    </v-col>
                </v-row>
            </v-form>
        </v-card>
    </div>
</template>
  


<!--recferences// https://vee-validate.logaretm.com/v4/tutorials/basics/ -->
<script>
import Swal from 'sweetalert2'

import http from '../../htpp.common';
export default {
    emits: ['isCancelChangePassword'],
    data() {
        return {
            visibleCurrent: false,
            visibleNew: false,
            visibleConfirm: false,
            passwordShow: false,

            currentPassword: '',
            newPassword: '',
            confirmPassword: '',
            successMessage: '',
            errorMessage: '',

            emailRules: [
                v => !!v || 'Current password is required',
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
                    }).then(() => {
                        this.$emit('isCancelChangePassword', false);
                    });
                    // this.$emit('isCancelChangePassword', false);
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
        cancelChangePassword() {
            this.$emit('isCancelChangePassword', true);
            console.log('get all changes');
        }
    },

};
</script>
<template>
  <v-card width="500">
    <v-card-title class="bg-primary">Change Password</v-card-title>
    <v-form ref="form" @submit.prevent="changePassword" class="pa-5">
      <v-text-field
        :append-inner-icon="visibleCurrent ? 'mdi-eye-off' : 'mdi-eye'"
        :type="visibleCurrent ? 'text' : 'password'"
        placeholder="Enter current password"
        prepend-inner-icon="mdi-lock-outline"
        v-model="currentPassword"
        :rules="newPasswordRole"
        variant="outlined"
        @click:append-inner="visibleCurrent = !visibleCurrent"
      >
      </v-text-field>
      <span :rules="currentPasswordRole"></span>
      <v-text-field
        :append-inner-icon="visibleNew ? 'mdi-eye-off' : 'mdi-eye'"
        :type="visibleNew ? 'text' : 'password'"
        placeholder="Enter your new password"
        prepend-inner-icon="mdi-lock-outline"
        v-model="newPassword"
        :rules="newPasswordRole"
        variant="outlined"
        class="mt-4"
        @click:append-inner="visibleNew = !visibleNew"
      >
      </v-text-field>
      <v-text-field
        :append-inner-icon="visibleConfirm ? 'mdi-eye-off' : 'mdi-eye'"
        :type="visibleConfirm ? 'text' : 'password'"
        placeholder="Enter your confirm new password"
        prepend-inner-icon="mdi-lock-outline"
        v-model="confirmPassword"
        :rules="confirmPasswordRoles"
        variant="outlined"
        class="mt-4"
        @click:append-inner="visibleConfirm = !visibleConfirm"
      >
      </v-text-field>

      <v-row no-gutters>
        <v-spacer></v-spacer>
        <v-btn @Click="cancel" class="mt-4 w-25" color="teal-darken-4" variant="outlined"
          >Cancel</v-btn
        >
        <v-btn type="submit" color="teal-darken-4" class="mt-4 ms-1">Save Change</v-btn>
      </v-row>
    </v-form>
  </v-card>
</template>
<script>
import http from '@/api/api'
import { useAuthStore } from '@/stores/auth'
import { mapActions } from 'pinia'
export default {
  emits: ['cancel', 'password-changed'],
  data() {
    return {
      snackbarVisible: false,
      visibleCurrent: false,
      visibleNew: false,
      visibleConfirm: false,

      currentPassword: '',
      newPassword: '',
      confirmPassword: '',

      currentPasswordRole: [
        v => !!v || 'Current password is required',
        v => (v && v.length >= 8) || 'Password must be 8  characters or more!'
      ],
      newPasswordRole: [
        v => !!v || 'New password is required',
        v => (v && v.length >= 8) || 'Password must be 8  characters or more!'
      ],
      confirmPasswordRoles: [
        v => !!v || 'Confirm new password is required',
        v => (v && v.length >= 8) || 'Password must be 8  characters or more!',
        v => v === this.newPassword || 'Passwords do not match'
      ]
    }
  },
  methods: {
    ...mapActions(useAuthStore, ['userChangePassword']),
    changePassword() {
      if (this.newPassword !== this.confirmPassword) {
        this.confirmPasswordRoles = ['Confirm password does not match']
        return
      }
      const data = {
        current_password: this.currentPassword,
        new_password: this.newPassword,
        new_password_confirmation: this.confirmPassword
      }
      this.userChangePassword(data)
        .then(() => {
          this.currentPassword = ''
          this.newPassword = ''
          this.confirmPassword = ''
          this.$emit('password-changed')
        })
        .catch(error => {
          if (
            error.response &&
            error.response.status === 400 &&
            error.response.data.error === 'Current password is incorrect'
          ) {
            this.currentPasswordRole = [
              'The current password you entered is incorrect. Please try again.'
            ]
          } else if (error.response && error.response.status === 400) {
            const errorData = error.response.data
            if (errorData.error && errorData.error.current_password) {
              this.currentPasswordRole = [errorData.error.current_password[0]]
            } else if (errorData.error && errorData.error.new_password) {
              this.newPasswordRole = [errorData.error.new_password[0]]
            } else {
              console.log(errorData)
            }
          } else if (error.response && error.response.status === 404) {
            const errorData = error.response.data
            if (errorData.error === 'User not found') {
              this.currentPasswordRole = ['User not found. Please try again.']
            } else {
              console.log(errorData)
            }
          } else {
            console.log(error)
          }
        })
    },
    cancel() {
      this.$emit('cancel')
    }
  }
}
</script>

<style scoped>
.snackbar {
  margin-bottom: 38%;
}
</style>

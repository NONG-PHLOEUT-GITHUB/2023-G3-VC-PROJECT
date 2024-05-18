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
        :rules="currentPasswordRole"
        :error-messages="currentPasswordError"
        variant="outlined"
        @click:append-inner="visibleCurrent = !visibleCurrent"
      >
      </v-text-field>
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
        :error-messages="confirmPasswordError"
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
      currentPasswordError: '',
      confirmPasswordError: '',

      currentPasswordRole: [
        v => !!v || 'Current password is required.',
        v => (v && v.length >= 8) || 'Password must be 8  characters or more!'
      ],
      newPasswordRole: [
        v => !!v || 'New password is required.',
        v => (v && v.length >= 8) || 'Password must be 8  characters or more!'
      ],
      confirmPasswordRoles: [
        v => !!v || 'Confirm new password is required.',
        v => (v && v.length >= 8) || 'Password must be 8  characters or more!'
      ]
    }
  },
  methods: {
    ...mapActions(useAuthStore, ['userChangePassword']),
    changePassword() {
      if (this.newPassword !== this.confirmPassword) {
        this.confirmPasswordError = 'Confirm password does not match'
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
          if (error.response.status === 400) {
            this.currentPasswordError = 'Current password is incorrect.'
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

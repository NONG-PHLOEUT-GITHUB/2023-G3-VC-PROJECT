<template>
    <v-dialog v-model="isDialogVisible" width="auto" persistent>
      <v-card max-width="400">
        <v-toolbar class="bg-info">
          <template v-slot:prepend>
            <v-btn icon="mdi-timer-stop-outline"></v-btn>
          </template>

          <v-toolbar-title
            class="text-h6"
            text="Session Expired"
          ></v-toolbar-title>
        </v-toolbar>
        <v-card-text>
          Your session has expired. Please log in again to continue.
        </v-card-text>
        <template v-slot:actions>
          <v-btn
            class="ms-auto"
            text="Login"
            color="primary"
            variant="outlined"
            @click="closeDialog"
          ></v-btn>
        </template>
      </v-card>
    </v-dialog>
</template>

<script>
  import { useCommonStore } from '@/stores/common'
  import { mapState, mapActions } from 'pinia'

  export default {
    computed: {
      ...mapState(useCommonStore, ['isTokenExpired']),
      isDialogVisible() {
        return this.isTokenExpired
      }
    },
    methods: {
      ...mapActions(useCommonStore, ['setTokenExpired']),
      closeDialog() {
        this.setTokenExpired(false)
        this.$router.push('/login')
      }
    }
  }
</script>

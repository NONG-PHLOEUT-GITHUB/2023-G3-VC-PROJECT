<template>
  <custom-title icon="mdi-account-details-outline">
    <template #right>
      <v-btn
        class="text-none"
        variant="outlined"
        color="primary"
        append-icon="mdi-pencil"
        @click="isEdit = !isEdit"
        >Edit profile
      </v-btn>
    </template>
  </custom-title>
  <v-layout class="rounded rounded-md px-0">
    <v-col cols="3">
      <v-card>
        <v-card-text class="px-0 text-center">
          <v-col>
            <div>
              <v-avatar color="grey" rounded="100" size="150" class="elevation-1">
                <v-img :src="authUser.profile" cover></v-img>
              </v-avatar>
            </div>
            <v-btn class="mt-2" :disabled="isEdit">upload new profile</v-btn>
          </v-col>
        </v-card-text>
      </v-card>
    </v-col>
    <v-col cols="9" class="pa-1">
      <v-card class="px-2">
        <custom-sub-title icon="mdi-account-card">Personal Information</custom-sub-title>
        <v-row>
          <v-col>
            <v-text-field
              v-model="authUser.first_name"
              density="compact"
              label="First name"
              variant="outlined"
              prepend-inner-icon="mdi-card-account-details-outline"
              :readonly="isEdit"
            ></v-text-field>
          </v-col>
          <v-col>
            <v-text-field
              v-model="authUser.last_name"
              density="compact"
              label="Last name"
              variant="outlined"
              :readonly="isEdit"
              prepend-inner-icon="mdi-card-account-details-outline"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-text-field
              v-model="authUser.gender"
              density="compact"
              label="Gender"
              variant="outlined"
              :readonly="isEdit"
              prepend-inner-icon="mdi-gender-male-female"
            ></v-text-field>
          </v-col>
          <v-col>
            <v-text-field
              v-model="authUser.date_of_birth"
              density="compact"
              label="Date of birth"
              variant="outlined"
              :readonly="isEdit"
              prepend-inner-icon=" mdi-calendar-range"
            ></v-text-field>
            <v-text-field
              v-model="authUser.age"
              density="compact"
              label="Age"
              variant="outlined"
              :readonly="isEdit"
              prepend-inner-icon="mdi-calendar-multiple-check"
            ></v-text-field>
          </v-col>
        </v-row>
        <custom-sub-title icon="mdi-contacts">Contact Information</custom-sub-title>
        <v-row>
          <v-col>
            <v-text-field
              v-model="authUser.email"
              density="compact"
              label="Email"
              variant="outlined"
              :readonly="isEdit"
              prepend-inner-icon="mdi-email"
            ></v-text-field>
          </v-col>
          <v-col>
            <v-text-field
              v-model="authUser.phone_number"
              density="compact"
              label="Phone number"
              variant="outlined"
              :readonly="isEdit"
              prepend-inner-icon="mdi-phone"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-text-field
              v-model="authUser.address"
              density="compact"
              label="Address"
              variant="outlined"
              :readonly="isEdit"
              prepend-inner-icon="mdi-map-marker"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-card-actions class="px-0">
          <v-btn color="red" variant="outlined">Cancel</v-btn>
          <v-btn class="bg-primary" :disabled="isEdit">Save change</v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-layout>
</template>

<script>
import { useAuthStore } from '@/stores/auth'
import { mapActions, mapState } from 'pinia'
export default {
  name: 'UserDetails',
  data() {
    return {
      isEdit: true,
      users: ' ',
      first_name: '',
      last_name: '',
      gender: '',
      date_of_birth: '3/4/2002',
      profile_image: '',
      age: '',
      email: '',
      address: '',
      phone_number: ''
    }
  },
  created() {
    this.fetchUser()
  },
  computed: {
    ...mapState(useAuthStore, ['authUser'])
  },
  methods: {
    ...mapActions(useAuthStore, ['fetchUser'])
  }
}
</script>

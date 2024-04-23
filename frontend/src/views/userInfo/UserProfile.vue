<template>
  <custom-title icon="mdi-account-details-outline"></custom-title>
  <v-layout class="rounded rounded-md px-0">
    <v-col cols="3">
      <v-card>
        <v-card-text class="px-0 text-center">
          <v-col>
            <div>
              <v-avatar color="grey" rounded="100" size="150" class="elevation-1">
                <v-img
                  src="https://i.pinimg.com/236x/14/ef/8c/14ef8c9eaf9de152e34568e53806a838.jpg"
                  cover
                ></v-img>
              </v-avatar>
            </div>
            <v-btn class="mt-2" :disabled="isEdit">upload new profile</v-btn>
          </v-col>
        </v-card-text>
      </v-card>
    </v-col>
    <v-col cols="9">
      <v-card class="px-2">
        <template v-slot:append>
          <v-tooltip text="Edit profile">
            <template v-slot:activator="{ props }">
              <v-btn v-bind="props" color="primary" icon="mdi-pencil"  @click="isEdit = !isEdit"></v-btn>
            </template>
          </v-tooltip>
        </template>
        <custom-sub-title icon="mdi-account-card">Personal Information</custom-sub-title>
        <v-row>
          <v-col>
            <v-text-field
              v-model="first_name"
              density="compact"
              label="First name"
              variant="outlined"
              prepend-inner-icon="mdi-card-account-details-outline"
              :readonly="isEdit"
            ></v-text-field>
          </v-col>
          <v-col>
            <v-text-field
              v-model="last_name"
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
              density="compact"
              label="Gender"
              variant="outlined"
              :readonly="isEdit"
              prepend-inner-icon="mdi-gender-male-female"
            ></v-text-field>
          </v-col>
          <v-col>
            <v-text-field
              v-model="date_of_birth"
              density="compact"
              label="Date of birth"
              variant="outlined"
              :readonly="isEdit"
              prepend-inner-icon=" mdi-calendar-range"
            ></v-text-field>
            <v-text-field
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
              density="compact"
              label="Email"
              variant="outlined"
              :readonly="isEdit"
              prepend-inner-icon="mdi-email"
            ></v-text-field>
          </v-col>
          <v-col>
            <v-text-field
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
import http from '@/api/api'
export default {
  name: 'UserDetails',
  data() {
    return {
      isEdit: true,
      users: ' ',
      first_name: 'Haka',
      last_name: 'Haka',
      date_of_birth: '3/4/2002'
    }
  },
  methods: {
    // fetchData() {
    //   http.get('/v1/auth/user').then(response => {
    //     this.users = response.data.data
    //   })
    // },
  },

  mounted() {
    // this.fetchData()
  }
}
</script>

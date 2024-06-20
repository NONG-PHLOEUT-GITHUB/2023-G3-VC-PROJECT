<template>
    <v-form class="mb-4">
      <v-card class="py-4 px-3 elevation-0">
        <v-row>
          <v-col cols="12" md="4" lg="4">
            <v-text-field
              hide-details
              density="compact"
              variant="outlined"
              label="First name"
              v-model="first_name"
              @keyup="applyFilter"
              color="textField"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4" lg="4">
            <v-text-field
              hide-details
              density="compact"
              variant="outlined"
              label="Last name"
              v-model="last_name"
              @keyup="applyFilter"
              color="textField"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4" lg="4">
            <v-text-field
              hide-details
              density="compact"
              variant="outlined"
              label="Phone Number"
              v-model="phone_number"
              @keyup="applyFilter"
              color="textField"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="4" lg="4">
            <v-text-field
              hide-details
              density="compact"
              variant="outlined"
              v-model="date_of_birth"
              label="Date of birth"
              @keyup="applyFilter"
              color="textField"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4" lg="4">
            <v-text-field
              hide-details
              density="compact"
              variant="outlined"
              label="Email"
              v-model="email"
              @keyup="applyFilter"
              color="textField"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4" lg="4">
            <v-text-field
              hide-details
              density="compact"
              variant="outlined"
              label="address"
              v-model="address"
              @keyup="applyFilter"
              color="textField"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-card>
    </v-form>
  </template>
  
  <script>
  export default {
    data() {
      return {
        first_name: '',
        last_name: '',
        email: '',
        phone_number: '',
        date_of_birth: '',
        address: '',
      }
    },
    methods: {
      applyFilter() {
        const filterData = {
          first_name: this.first_name,
          last_name: this.last_name,
          email: this.email,
          phone_number: this.phone_number,
          date_of_birth: this.date_of_birth,
          address: this.address,
        }
        this.$emit('filter-student', filterData)
      }
    }
  }
  </script>
  
<template>
  <v-form class="mb-4">
    <v-card class="py-4 px-3">
      <v-row>
        <v-col>
          <v-text-field
            hide-details
            density="compact"
            variant="outlined"
            label="First name"
            v-model="first_name"
            @keyup="applyFilter"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            hide-details
            density="compact"
            variant="outlined"
            label="Last name"
            v-model="last_name"
            @keyup="applyFilter"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            hide-details
            density="compact"
            variant="outlined"
            label="Phone Number"
            v-model="phone_number"
            @keyup="applyFilter"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-text-field
            hide-details
            density="compact"
            variant="outlined"
            v-model="date_of_birth"
            label="Date of birth"
            @keyup="applyFilter"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            hide-details
            density="compact"
            variant="outlined"
            label="Email"
            v-model="email"
            @keyup="applyFilter"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            hide-details
            density="compact"
            variant="outlined"
            label="address"
            v-model="address"
            @keyup="applyFilter"
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
      this.$emit('filter-user', filterData)
    }
  }
}
</script>

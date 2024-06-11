<template>
  <v-form class="mb-4">
    <v-card class="py-4 px-3">
      <v-row>
        <v-col>
          <v-text-field
            v-model="first_name"
            @keyup="applyFilter"
            hide-details
            density="compact"
            variant="outlined"
            label="First name"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            v-model="last_name"
            @keyup="applyFilter"
            hide-details
            density="compact"
            variant="outlined"
            label="Last name"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            v-model="phone_number"
            @keyup="applyFilter"
            hide-details
            density="compact"
            variant="outlined"
            label="Phone Number"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-text-field
            v-model="date_of_birth"
            @keyup="applyFilter"
            hide-details
            density="compact"
            variant="outlined"
            label="Date of birth"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            v-model="email"
            @keyup="applyFilter"
            hide-details
            density="compact"
            variant="outlined"
            label="Email"
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
      }
      this.$emit('filter-guardian', filterData)
    }
  }
}
</script>

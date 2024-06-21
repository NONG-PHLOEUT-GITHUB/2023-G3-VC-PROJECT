<template>
  <v-form class="mb-4">
    <v-card class="py-4 px-3 elevation-0">
      <v-row>
        <v-col cols="12" md="4" lg="4">
          <v-text-field
            v-model="first_name"
            @keyup="applyFilter"
            hide-details
            density="compact"
            variant="outlined"
            label="First name"
            color="textField"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="4" lg="4">
          <v-text-field
            v-model="last_name"
            @keyup="applyFilter"
            hide-details
            density="compact"
            variant="outlined"
            label="Last name"
            color="textField"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="4" lg="4">
          <v-text-field
            v-model="phone_number"
            @keyup="applyFilter"
            hide-details
            density="compact"
            variant="outlined"
            label="Phone Number"
            color="textField"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" md="6" lg="6">
          <v-text-field
            v-model="date_of_birth"
            @keyup="applyFilter"
            hide-details
            density="compact"
            variant="outlined"
            label="Date of birth"
            color="textField"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="6" lg="6">
          <v-text-field
            v-model="chat_id"
            @keyup="applyFilter"
            hide-details
            density="compact"
            variant="outlined"
            label="Chat id"
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
      chat_id: '',
      phone_number: '',
      date_of_birth: '',
    }
  },
  methods: {
    applyFilter() {
      const filterData = {
        first_name: this.first_name,
        last_name: this.last_name,
        chat_id: this.chat_id,
        phone_number: this.phone_number,
        date_of_birth: this.date_of_birth,
      }
      this.$emit('filter-guardian', filterData)
    }
  }
}
</script>

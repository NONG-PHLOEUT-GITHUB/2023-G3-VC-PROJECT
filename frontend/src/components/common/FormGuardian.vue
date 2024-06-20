<template>
  <custom-sub-title icon="mdi-information">Parent Information</custom-sub-title>
  <form class="row g-3 card-body pt-4" @submit.prevent="emitSubmit()">
    <v-row>
      <v-col>
        <v-text-field
          variant="outlined"
          v-model="formData.first_name"
          label="First name"
          color="textField"
        ></v-text-field>
      </v-col>
      <v-col>
        <v-text-field
          variant="outlined"
          v-model="formData.last_name"
          label="Last name"
          color="textField"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-text-field
          label="Date of birth"
          variant="outlined"
          v-model="formData.date_of_birth"
          type="date"
          color="textField"
        ></v-text-field>
      </v-col>
      <v-col>
        <v-text-field
          variant="outlined"
          v-model="formData.address"
          label="Address"
          color="textField"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-radio-group inline v-model="formData.gender">
      <v-radio value="Male" label="Male"></v-radio>
      <v-radio value="Female" label="Female"></v-radio>
    </v-radio-group>
    <v-row>
      <v-col>
        <v-text-field
          variant="outlined"
          v-model="formData.chat_id"
          label="Chat id of guadian"
          color="textField"
        ></v-text-field>
      </v-col>
      <v-col>
        <v-text-field
          variant="outlined"
          v-model="formData.phone_number"
          label="Phone Number"
          color="textField"
        ></v-text-field>
      </v-col>
    </v-row>
  </form>
</template>
<script>
  export default {
    // Declare the custom event 'submit' that the component emits
    emits: ['submit'],
    props: {
      guardianDetails: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        formData: {
          id: '',
          first_name: '',
          last_name: '',
          gender: '',
          chat_id: '',
          phone_number: '',
          address: '',
          date_of_birth: ''
        }
      }
    },
    watch: {
      guardianDetails: {
        immediate: true,
        handler(newDetails) {
          this.formData = { ...newDetails }
        }
      }
    },
    methods: {
      emitSubmit() {
        this.$emit('submit', this.formData)
      }
    }
  }
</script>

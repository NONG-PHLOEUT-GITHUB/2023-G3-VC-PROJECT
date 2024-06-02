<template>
  <v-form @submit.prevent="" class="mb-4">
    <v-card class="py-4 px-3">
      <v-row>
        <v-col>
          <v-text-field
            hide-details
            density="compact"
            variant="outlined"
            label="Classroom name"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            hide-details
            density="compact"
            variant="outlined"
            label="Coordinator name"
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
      profilePreview: null,
      first_name: '',
      last_name: '',
      email: '',
      phone_number: '',
      address: '',
      date_of_birth: '',
      age: '',
      gender: '',
      profile: '',
      role: '',
      class_room_id: null,
      guardian_id: null,
      listUser: [],
      classrooms: [],
      guardians: [],
      roleOption: [
        { value: '1', title: 'Administrator' },
        { value: '2', title: 'Teacher' },
        { value: '3', title: 'Student' }
      ]
    }
  }
}
</script>

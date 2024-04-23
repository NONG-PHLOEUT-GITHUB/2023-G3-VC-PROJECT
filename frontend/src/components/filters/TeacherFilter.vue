<template>
  <v-form @submit.prevent="" class="mb-4">
    <v-row>
      <v-col>
        <v-text-field
          hide-details
          density="compact"
          variant="outlined"
          label="First name"
        ></v-text-field>
      </v-col>
      <v-col>
        <v-text-field
          hide-details
          density="compact"
          variant="outlined"
          label="Last name"
        ></v-text-field>
      </v-col>
      <v-col>
        <v-text-field
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
          hide-details
          density="compact"
          variant="outlined"
          v-model="date_of_birth"
          label="Date of birth"
        ></v-text-field>
      </v-col>
      <v-col>
        <v-text-field
          hide-details
          density="compact"
          variant="outlined"
          label="Email"
        ></v-text-field>
      </v-col>
      <v-col>
        <v-select
          density="compact"
          variant="outlined"
          label="Role"
          :items="roleOption"
          item-title="title"
          item-value="value"
          chips
          multiple
          hide-details
        ></v-select>
      </v-col>
    </v-row>
    <!-- <div class="col-12 d-flex justify-content-end">
      <v-btn type="submit" class="bg-primary">Add User</v-btn>
    </div> -->
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

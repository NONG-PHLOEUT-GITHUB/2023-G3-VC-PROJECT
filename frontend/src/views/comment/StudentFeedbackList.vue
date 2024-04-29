<template>
  <custom-title icon="mdi-eye-check-outline">
    <template #right>
      <v-btn
        icon="mdi-filter-multiple-outline"
        variant="tonal"
        class="me-2 bg-primary"
        @click="toggleFilter = !toggleFilter"
      ></v-btn>
      <v-btn
        variant="tonal"
        class="me-2 bg-green-darken-1"
        icon="mdi-send-circle"
        @click="submitForm()"
      ></v-btn>
    </template>
  </custom-title>
  <v-data-table-server
    v-model:items-per-page="itemsPerPage"
    :headers="headers"
    :items="studentInClassroom"
    :items-length="studentInClassroom.length"
    :loading="loading"
    item-value="name"
    class="elevation-2"
    >
    <!-- :search="search" -->
    <template v-slot:item.profile="{ item }">
      <v-avatar size="large">
        <v-img :src="item.profile" alt="Avatar" cover> </v-img>
      </v-avatar>
    </template>
    <template template v-slot:item.actions="{ item }">
      <v-btn :to="'/feedback/'+ item.id + '/student'" icon="mdi-comment"></v-btn>
    </template>
  </v-data-table-server>
</template>

<script>
import { mapActions, mapState } from 'pinia'
import { useClassroomStore } from '@/stores/classroom'
export default {
  data() {
    return {
      students: [],
      date: null,
      chat_id: null,
      classrooms: [],
      itemsPerPage: 10,
      loading: false,
      headers: [
        { title: 'Profile', key: 'profile' },
        { title: 'First Name', key: 'first_name' },
        { title: 'Last Name', key: 'last_name' },
        { title: 'Gender', key: 'gender' },
        { title: 'Email', key: 'email' },
        { title: '', key: 'actions' },
      ],
      statusOptions: [
        { value: 'Present', label: 'Present' },
        { value: 'Absent', label: 'Absent' },
        { value: 'Early', label: 'Early' },
        { value: 'Excused', label: 'Excused' },
        { value: 'Unexcused', label: 'Unexcused' },
        { value: 'On leave', label: 'On leave' },
        { value: 'No show', label: 'No show' }
      ]
    }
  },
  created() {
    const id = this.$route.params.classroomId
    this.getStudentsInClassroom(id)
  },
  computed: {
    ...mapState(useClassroomStore, ['studentInClassroom'])
  },
  methods: {
    ...mapActions(useClassroomStore, ['getStudentsInClassroom'])
  }
}
</script>

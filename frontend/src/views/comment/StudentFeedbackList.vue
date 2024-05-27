<template>
  <v-breadcrumbs :items="breadcrumbs" class="py-0 px-0">
    <template v-slot:prepend>
      <v-icon icon="mdi-chevron-left"></v-icon>
    </template>
  </v-breadcrumbs>
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
  <v-data-table
    :headers="headers"
    :items="studentInClassroom"
    :loading="loading"
    item-value="name"
    class="elevation-2"
  >
    <template v-slot:item.profile="{ item }">
      <v-avatar size="large">
        <v-img :src="item.profile" alt="Avatar" cover> </v-img>
      </v-avatar>
    </template>
    <template template v-slot:item.actions="{ item }">
      <v-btn :to="'/feedback/' + item.id + '/student'" variant="text" icon="mdi-comment"></v-btn>
    </template>
  </v-data-table>
</template>

<script>
import { mapActions, mapState } from 'pinia'
import { useClassroomStore } from '@/stores/classroom'
import { useStudentStore } from '@/stores/student'
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
        { title: '', key: 'actions' }
      ]
    }
  },
  created() {
    const id = this.$route.params.classroomId
    this.getStudentsInClassroom(id)
  },
  computed: {
    ...mapState(useClassroomStore, ['studentInClassroom']),
    breadcrumbs() {
      const user_role = parseInt(localStorage.getItem('user_role'))
      if (user_role === 1) {
        return [
          {
            title: 'Classroom Management',
            disabled: false,
            href: '/class-list'
          }
        ]
      } else {
        return [
          {
            title: 'Classroom',
            disabled: false,
            href: '/teacher-classroom'
          }
        ]
      }
    }
  },
  methods: {
    ...mapActions(useClassroomStore, ['getStudentsInClassroom'])
  }
}
</script>

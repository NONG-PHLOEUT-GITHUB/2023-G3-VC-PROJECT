<template>
  <custom-title icon="mdi-human-male-board">
    <template #right>
      <v-btn
        v-if="this.selectedUser.length > 0"
        variant="tonal"
        class="me-4 bg-deep-orange-accent-4"
        icon="mdi-delete-forever"
        @click="deleteMultiple"
      ></v-btn>
      <v-btn
        variant="outlined"
        append-icon="mdi-filter-multiple-outline"
        class="text-none me-4"
        color="primary"
        @click="toggleFilter = !toggleFilter"
        >{{ $t('btn.filter') }}</v-btn
      >
      <v-tooltip activator="parent" text="Export Excel" location="top">
        <template v-slot:activator="{ props }">
          <v-btn
            v-bind="props"
            variant="tonal"
            class="bg-green-darken-1"
            icon="mdi-file-excel"
          ></v-btn>
        </template>
      </v-tooltip>
    </template>
  </custom-title>
  <teacher-filter v-show="toggleFilter" />
  <v-card>
    <v-data-table
      show-select
      :headers="headers"
      :items="teachers"
      v-model="selectedUser"
      item-value="id"
      hover
    >
      <template v-slot:item.profile="{ item }">
        <v-avatar size="large">
          <v-img :src="item.profile" alt="Avatar" cover> </v-img>
        </v-avatar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-btn
          :to="{ path: '/user/' + item.id + '/edit' }"
          variant="text"
          icon="mdi-pencil"
        ></v-btn>

        <v-btn @click="removeTeacher(item.id)" variant="text" icon="mdi-delete-forever" color="red">
        </v-btn>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
import TeacherFilter from '@/components/filters/TeacherFilter.vue'
import { useTeacherStore } from '@/stores/teacher'
import { mapActions, mapState } from 'pinia'
import { useStudentStore } from '@/stores/student'
export default {
  components: {
    TeacherFilter
  },
  created() {
    this.getTeachers()
  },
  data() {
    return {
      toggleFilter: false,
      selectedUser: [],
      headers: [
        { title: 'Profile', key: 'profile' },
        { title: 'First Name', key: 'first_name' },
        { title: 'Last Name', key: 'last_name' },
        { title: 'Gender', key: 'gender' },
        { title: 'Age', key: 'age' },
        { title: 'Phone Number', key: 'phone_number' },
        { title: 'Email', key: 'email' },
        { title: '', key: 'actions', width: '15%' }
      ]
    }
  },
  computed: {
    ...mapState(useTeacherStore, ['teachers'])
  },
  methods: {
    ...mapActions(useTeacherStore, ['getTeachers', 'deleteTeacher']),
    ...mapActions(useStudentStore, ['deleteMultipleUsers']),
    removeTeacher(id) {
      this.deleteTeacher(id).then(response => {
        if (response.status == 200) {
          this.$root.$notif('Delete successfully', {
            type: 'success',
            color: 'primary'
          })
        }
        this.getTeachers()
      })
    },
    deleteMultiple() {
      this.deleteMultipleUsers(this.selectedUser).then(response => {
        if (response.status == 200) {
          this.$root.$notif('Delete successfully', {
            type: 'success',
            color: 'primary'
          })
          this.selectedUser = []
        }
        this.getTeachers()
      })
    }
  }
}
</script>

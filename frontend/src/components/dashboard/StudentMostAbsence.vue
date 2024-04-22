<template>
  <custom-sub-title class="mt-4">STUDENT MOST ABSENCE LIST</custom-sub-title>
  <v-data-table-server
    v-model:items-per-page="itemsPerPage"
    :headers="headers"
    :items="filteredAttendanceMostAbsencData"
    :items-length="filteredAttendanceMostAbsencData.length"
    :loading="loading"
    :search="search"
    item-value="name"
  >
    <template v-slot:item.profile="{ item }">
      <v-avatar size="large">
        <v-img :src="item.profile" alt="Avatar" cover> </v-img>
      </v-avatar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-btn :to="'/studentattendance/' + item.id + '/details'" icon="mdi-eye"></v-btn>
    </template>
  </v-data-table-server>
</template>
<script>
import http from '@/api/api'
export default {
  data() {
    return {
      user: [],
      attendanceMostAbsencData: [],
      headers: [
        {
          title: 'Profile',
          align: 'start',
          sortable: false,
          key: 'profile'
        },
        {
          title: 'First name',
          align: 'start',
          sortable: false,
          key: 'first_name'
        },
        {
          title: 'Last name',
          align: 'start',
          sortable: false,
          key: 'last_name'
        },
        { title: 'Gender', key: 'gender', align: 'end' },
        { title: 'Email', key: 'email', align: 'end' },
        { title: '', key: 'actions', align: 'end' }
      ],
      // pagination:[
      itemsPerPage: 10
      // ]
    }
  },
  mounted() {
    this.getMostAbsentStudents()
  },
  computed: {
    filteredAttendanceMostAbsencData() {
      return this.attendanceMostAbsencData.filter(user => user.role_attendances_count > 0)
    }
  },
  methods: {
    async getMostAbsentStudents() {
      try {
        const response = await http.get('/get-most-absence-student')
        this.attendanceMostAbsencData = response.data
      } catch (error) {
        console.log(error)
      }
    }
  }
}
</script>

<style scoped></style>

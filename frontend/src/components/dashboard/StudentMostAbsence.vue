<template>
  <custom-sub-title class="mt-4" icon="mdi-chart-timeline">Student most absent list</custom-sub-title>
  <v-data-table-server
    v-model:items-per-page="itemsPerPage"
    :headers="headers"
    :items="attendanceMostAbsencData"
    :items-length="attendanceMostAbsencData.length"
    :loading="loading"
    :search="search"
    item-value="name"
    class="elevation-1"
  >
    <template v-slot:item.profile="{ item }">
      <v-avatar size="large">
        <v-img :src="item.profile" alt="Avatar" cover> </v-img>
      </v-avatar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-btn :to="'/student/attendance/' + item.id + '/details'" icon="mdi-eye"></v-btn>
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
          title: '#ID',
          align: 'start',
          sortable: false,
          key: 'id'
        },
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
        { title: 'Gender', key: 'gender', align: 'start' },
        { title: 'Email', key: 'email', align: 'start' },
        { title: '', key: 'actions', align: 'start' }
      ],
      itemsPerPage: 10
    }
  },
  mounted() {
    this.getMostAbsentStudents()
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

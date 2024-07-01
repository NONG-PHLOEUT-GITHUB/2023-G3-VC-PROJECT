<template>
  <custom-sub-title class="mt-4" icon="mdi-chart-timeline">
    {{ $t('common.titleAbsent') }}
  </custom-sub-title>
  <v-card rounded="xl" class="elevation-0">
    <v-data-table
      :headers="headers"
      :items="attendanceMostAbsencData"
      item-value="name"
      items-per-page="7"
    >
      <template v-slot:item.profile="{ item }">
        <v-avatar size="large">
          <v-img :src="item.profile" alt="Avatar" cover></v-img>
        </v-avatar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-btn
          :to="'/student/attendance/' + item.id + '/details'"
          icon="mdi-eye"
          variant="text"
        ></v-btn>
      </template>
    </v-data-table>
  </v-card>
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
            sortable: true,
            key: 'id'
          },
          {
            title: 'Profile',
            align: 'start',
            key: 'profile',
            width: '0px'
          },
          {
            title: 'First name',
            align: 'start',
            key: 'first_name',
          },
          {
            title: 'Last name',
            align: 'start',
            key: 'last_name'
          },
          { title: 'Email', key: 'email', align: 'start' },
          {
            title: 'Total',
            key: 'attendances_count',
            align: 'center',
            sortable: false
          },
          { title: '', key: 'actions', align: 'start', sortable: false }
        ]
      }
    },
    mounted() {
      this.getMostAbsentStudents()
    },
    methods: {
      async getMostAbsentStudents() {
        try {
          const response = await http.get(
            '/attendances/students/get-most-absence'
          )
          // this.loading = true
          this.attendanceMostAbsencData = response.data
        } catch (error) {
          console.log(error)
        }
      }
    }
  }
</script>

<style scoped></style>

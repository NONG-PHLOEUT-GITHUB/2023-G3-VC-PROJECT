<template>
   <v-btn
    size="x-small"
    icon="mdi-arrow-left"
    class="white mr-2"
    @click="goBack"
    variant="tonal"
  ></v-btn>
  <strong class="d-inline-block capitalize-first-letter">
    Classroom Details
  </strong>
  <custom-title icon="mdi-note-check-outline"></custom-title>
  <v-data-table
    :headers="headers"
    :items="attendanceData"
    :loading="loading"
    :search="search"
    item-value="id"
    items-key="title"
    class="elevation-0"
    show-expand
  >
    <template v-slot:expanded-row="{ columns, item }">
      <tr>
        <td :colspan="columns.length">
          <v-data-table-virtual
            :headers="headersAttendance"
            item-value="id"
            items-key="title"
            :items="item.attendances"
          >
            <template v-slot:item.status="{ value }">
              <v-chip :color="getColor(value)">
                {{ value }}
              </v-chip>
            </template>
            <template v-slot:item.actions="{ item }">
              <v-btn
                @click="removeStudent(item.id)"
                variant="text"
                icon="mdi-delete-forever"
                color="error"
              ></v-btn>
            </template>
          </v-data-table-virtual>
        </td>
      </tr>
    </template>
    <template v-slot:item.profile="{ item }">
      <v-avatar size="large">
        <v-img :src="item.profile" alt="Avatar" cover></v-img>
      </v-avatar>
    </template>
  </v-data-table>
</template>
<script>
  import http from '@/api/api'
  export default {
    data() {
      return {
        attendanceData: [],
        headers: [
          { title: 'Profile', key: 'profile' },
          { title: 'First Name', key: 'first_name' },
          { title: 'Last Name', key: 'last_name' }
        ],
        headersAttendance: [
          { title: 'Date', key: 'date' },
          { title: 'Reason', key: 'reason' },
          { title: 'Status', key: 'status' },
          { title: '', key: 'actions', width: '14%', sortable: false }
        ]
      }
    },
    methods: {
      getStudents(id) {
        http
          .get(`classrooms/student/${id}/attendance/`)
          .then(response => {
            this.attendanceData = response.data.data
          })
          .catch(error => {
            console.log(error)
          })
      },
      getColor (status) {
        if (status == "absent") return 'red'
        else if (status > 50) return 'orange'
        else return 'green'
      },
      goBack() {
        this.$router.back()
      },
      removeStudent(id) {
        http
          .delete(`attendances/${id}/delete-attendance/`)
          .then(response => {
            this.$root.$notif(this.$t('alert.delete'), {
              type: 'success',
              color: 'primary'
            })
            this.attendanceData = response.data.data
            const id = this.$route.params.id
            this.getStudents(id)
          })
          .catch(error => {
            console.log(error)
          })
      }
    },
    mounted() {
      const id = this.$route.params.id
      this.getStudents(id)
    }
  }
</script>

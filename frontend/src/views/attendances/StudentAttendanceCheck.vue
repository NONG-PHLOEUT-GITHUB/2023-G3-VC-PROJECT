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
        @click="createAttendance()"
      ></v-btn>
    </template>
  </custom-title>
  <v-row>
    <v-checkbox @click="SelectAttendace()" value="red" :label="this.date" hide-details>
    </v-checkbox>
  </v-row>
  {{ selectedValues }}
  <v-data-table
    v-model:items-per-page="itemsPerPage"
    v-model="selectedValues"
    :item-selectable="studentInClassroom.id"
    :headers="headers"
    :items="studentInClassroom"
    :items-length="studentInClassroom.length"
    :loading="loading"
    item-value="id"
    show-select
    class="elevation-2"
  >
    <!-- :search="search" -->
    <template v-slot:item.profile="{ item }">
      <v-avatar size="large">
        <v-img :src="item.profile" alt="Avatar" cover> </v-img>
      </v-avatar>
    </template>
    <template v-slot:item.status="{ item }">
      <v-select
        :items="statusOptions"
        variant="outlined"
        item-title="label"
        item-value="value"
        v-model="item.status"
      ></v-select>
    </template>
    <template v-slot:item.reason="{ item }">
      <v-textarea rows="1" variant="outlined" v-model="item.reason"></v-textarea>
    </template>
  </v-data-table>
</template>

<script>
import { mapActions, mapState } from 'pinia'
import { useClassroomStore } from '@/stores/classroom'
import { useAttendanceStore } from '@/stores/attendance'
import { useGuardianStore } from '@/stores/guardian'
import axios from 'axios'
export default {
  data() {
    return {
      selectedValues: [],
      loading: false,
      date: null,
      classrooms: [],
      itemsPerPage: 10,
      reason: '',
      telegramToken:
        'https://api.telegram.org/bot6454815254:AAGSFsqSRlS2kBCREs5Kt0NDnVFZjk0fUIU/sendMessage',
      headers: [
        { title: 'Profile', key: 'profile' },
        { title: 'First Name', key: 'first_name' },
        { title: 'Last Name', key: 'last_name' },
        { title: 'Gender', key: 'gender' },
        { title: 'Email', key: 'email' },
        { title: 'Status', key: 'status', width: '200' },
        { title: 'Reason', key: 'reason' }
      ],
      statusOptions: [
        { value: 'Present', label: 'Present' },
        { value: 'Absent', label: 'Absent' },
        { value: 'Early', label: 'Early' },
        { value: 'Excused', label: 'Excused' },
        { value: 'Unexcused', label: 'Unexcused' },
        { value: 'On leave', label: 'On leave' },
        { value: 'No show', label: 'No show' }
      ],
      breadcrumbs: [
        {
          title: 'Classroom',
          disabled: false,
          href: '/teacher-classroom'
        },
      ],
    }
  },
  created() {
    const id = this.$route.params.classroomId
    this.getStudentsInClassroom(id)
  },
  computed: {
    ...mapState(useClassroomStore, ['studentInClassroom']),
    ...mapState(useGuardianStore, ['chat_id'])
  },
  methods: {
    ...mapActions(useClassroomStore, ['getStudentsInClassroom']),
    ...mapActions(useAttendanceStore, ['checkAttendance']),
    ...mapActions(useGuardianStore, ['getChatIdOfGuardian']),

    createAttendance() {
      this.selectedValues.forEach(selected => {
        // Prepare attendance data
        const formData = {
          status: selected.status,
          reason: selected.reason,
          date: this.date,
          user_id: selected
        }
        this.getChatIdOfGuardian(selected)
        this.checkAttendance(formData).then(res => {
          // console.log(res)
          // const message = `Name: ${student.first_name} ${student.last_name}\nGender: ${student.gender}\nStatus: ${student.status}\nReason: ${student.reason}`

          axios.post(process.env.VUE_APP_TELEGRAM_BASE_TOKEN, {
            chat_id: this.chat_id,
            text: "message"
          })
        })
      })
    }
  }
}

// this.getChatId(student.id) // pass the guardian_id as the parameter
// const message = `Name: ${student.first_name} ${student.last_name}\nGender: ${student.gender}\nStatus: ${student.status}\nReason: ${student.reason}`
// const response = axios.post(telegramToken, {
//   chat_id: this.chat_id,
//   text: message
// })
</script>





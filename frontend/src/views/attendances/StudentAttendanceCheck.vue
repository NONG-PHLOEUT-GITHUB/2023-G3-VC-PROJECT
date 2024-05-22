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
  <v-col>
    <v-date-input
      label="Select a date"
      prepend-icon=""
      prepend-inner-icon="$calendar"
      variant="outlined"
      v-model="checkDate"
    ></v-date-input>
  </v-col>
  <!-- {{ studentInClassroom }} -->
  <v-data-table
    v-model="selectedValues"
    :item-selectable="studentInClassroom.id"
    :headers="headers"
    :items="studentInClassroom"
    item-value="id"
    class="elevation-2"
    >
    <!-- show-select -->
    <template v-slot:body="{ items }">
      <tr v-for="item in items">
        <td>
          <v-checkbox
          v-model="selectedValues"
            class="selectstudent"
            color="red"
            value="red"
            hide-details
          ></v-checkbox>
        </td>
        <td>
          <v-avatar size="large">
            <v-img :src="item.profile" alt="Avatar" cover> </v-img>
          </v-avatar>
        </td>
        <td>{{ item.first_name }}</td>
        <td>{{ item.last_name }}</td>
        <td>{{ item.gender }}</td>
        <td>{{ item.email }}</td>
        <td>
          <v-select
            :items="statusOptions"
            variant="outlined"
            item-title="label"
            item-value="value"
            v-model="status"
          ></v-select>
        </td>
        <td><v-textarea rows="1" variant="outlined" v-model="reason"></v-textarea></td>
      </tr>
    </template>
    <!-- @click:row="onRowClick" -->
  </v-data-table>
</template>

<script>
import { mapActions, mapState } from 'pinia'
import { useClassroomStore } from '@/stores/classroom'
import { useAttendanceStore } from '@/stores/attendance'
import { useGuardianStore } from '@/stores/guardian'
import axios from 'axios'
import { format } from 'date-fns'
export default {
  data() {
    return {
      selectedValues: [],
      loading: false,
      checkDate: null,
      itemsPerPage: 10,
      reason: '',
      status: '',
      headers: [
        { title: 'Select', key: 'select' },
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
        }
      ]
    }
  },
  created() {
    const id = this.$route.params.classroomId
    this.getStudentsInClassroom(id)
  },
  computed: {
    ...mapState(useClassroomStore, ['studentInClassroom']),
    ...mapState(useGuardianStore, ['chat_id']),
    formattedDate() {
      // Use the format function to format the date
      return format(this.checkDate, 'yyyy-MM-dd')
    }
  },
  methods: {
    ...mapActions(useClassroomStore, ['getStudentsInClassroom']),
    ...mapActions(useAttendanceStore, ['checkAttendance']),
    ...mapActions(useGuardianStore, ['getChatIdOfGuardian']),
    onRowClick(event, { item }) {
      console.log('Row clicked:', item)
      alert(`You clicked on ${item.name}`)
    },
    createAttendance() {
      this.selectedValues.forEach(selected => {
        // Prepare attendance data
        console.log(this.selectedValues)
        const formData = {
          status: selected.status,
          reason: selected.reason,
          date: this.formattedDate,
          user_id: selected
        }
        this.getChatIdOfGuardian(selected)
        this.checkAttendance(formData).then(res => {
          console.log(res)
          // const message = `Name: ${student.first_name} ${student.last_name}\nGender: ${student.gender}\nStatus: ${student.status}\nReason: ${student.reason}`

          axios.post(process.env.VUE_APP_TELEGRAM_BASE_TOKEN, {
            chat_id: this.chat_id,
            text: message
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

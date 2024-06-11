<template>
  <v-breadcrumbs :items="breadcrumbs" class="py-0 px-0">
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
  <v-col cols="4" class="pa-0">
    <v-date-input
      :allowed-dates="allowedDates"
      label="Select a date"
      prepend-icon=""
      prepend-inner-icon="$calendar"
      variant="outlined"
      v-model="checkDate"
      :rules="[() => !!checkDate || 'This field is required']"
    ></v-date-input>
  </v-col>

  <v-data-table
    v-model="selectedValues"
    :headers="headers"
    :items="studentInClassroom"
    item-value="id"
    class="elevation-2"
  >
    <template v-slot:body="{ items }">
      <tr v-for="item in items" :key="item.id">
        <td>
          <v-switch
            @update:modelValue="getSelected(item)"
            inset
            v-model="item.selected"
            color="red"
            :false-value="switchValue"
            :true-value="switchValue"
            false-icon="mdi-plus"
            true-icon="mdi-check"
          ></v-switch>
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
            v-model="item.status"
          ></v-select>
        </td>
        <td><v-textarea rows="1" variant="outlined" v-model="item.reason"></v-textarea></td>
      </tr>
    </template>
  </v-data-table>
</template>

<script>
import { mapActions, mapState } from 'pinia'
import { useClassroomStore } from '@/stores/classroom'
import { useAttendanceStore } from '@/stores/attendance'
import axios from 'axios'
import { format } from 'date-fns'
export default {
  data() {
    return {
      selectedValues: [],
      chat_id: '',
      loading: false,
      checkDate: null,
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
    formattedDate() {
      // Use the format function to format the date
      // return format(this.checkDate, 'yyyy-MM-dd')
      if (!(this.checkDate instanceof Date) || isNaN(this.checkDate.getTime())) {
        return '' // Return an empty string or another default value if this.checkDate is not valid
      }
      // Use the format function to format the date
      return format(this.checkDate, 'yyyy-MM-dd')
    }
  },
  methods: {
    ...mapActions(useClassroomStore, ['getStudentsInClassroom']),
    ...mapActions(useAttendanceStore, ['checkAttendance']),
    allowedDates(date) {
      const today = new Date()
      today.setHours(0, 0, 0, 0) // Ensure comparison is only by date, not time
      const selectedDate = new Date(date)
      selectedDate.setHours(0, 0, 0, 0) // Ensure comparison is only by date, not time
      return selectedDate <= today
    },
    getSelected(item) {
      this.selectedValues.push(item)
    },
    createAttendance() {
      if (!this.formattedDate || isNaN(new Date(this.formattedDate))) {
        this.$root.$notif('Please select a date', {
          type: 'warning',
          color: 'yellow'
        })
        return // Exit the function early if the date is empty
      }

      // Define an array to store promises
      const promises = []

      this.selectedValues.forEach(selected => {
        const formData = {
          status: selected.status || '', // Default to 'undefined' if status is not provided
          reason: selected.reason || '', // Default to 'undefined' if reason is not provided
          date: this.formattedDate,
          user_id: selected.id
        }
        promises.push(
          this.checkAttendance(formData)
            .then(() => {
              const message = `Student name: ${selected.first_name} ${selected.last_name}\nGender: ${selected.gender}\nStatus: ${selected.status}\nReason: ${selected.reason}\nAbsent date: ${this.formattedDate}`

              axios.post(process.env.VUE_APP_TELEGRAM_BASE_TOKEN, {
                chat_id: selected.parent_chat_id, // Use parent_chat_id for the Telegram message
                text: message
              })
            })
            .catch(err => {
              this.$root.$notif(err, {
                type: 'error',
                color: 'red'
              })
              throw err
            })
        )
      })
      // Wait for all promises to resolve
      Promise.all(promises)
        .then(() => {
          this.$root.$notif(this.$t('alert.create'), {
            type: 'success',
            color: 'primary'
          })
          this.selectedValues = []
          this.switchValue = false
        })
        .catch(err => {
          console.error('Error creating attendance:', err)
        })
    }
  }
}
</script>

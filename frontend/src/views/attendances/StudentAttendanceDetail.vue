<template>
  <v-breadcrumbs :items="breadcrumbs" class="py-0 px-0">
    <template v-slot:prepend>
      <v-icon icon="mdi-chevron-left"></v-icon>
    </template>
  </v-breadcrumbs>
  <custom-title icon="mdi-account-details-outline">
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
        icon="mdi-export-variant"
        @click="exportExcel()"
      ></v-btn>
      <v-btn
        variant="tonal"
        class="me-2 bg-green-darken-1"
        icon="mdi-send-circle"
        @click="sendAttendancStudentAsExecl()"
      ></v-btn>
    </template>
  </custom-title>
  <!-- <custom-sub-title>
    Attendance of <strong class="ms-2">{{ user.first_name }} {{ user.last_name }}</strong>
  </custom-sub-title> -->

  <!-- v-model="selected" -->
  <v-data-table
    :headers="headers"
    :items="attendanceDetails"
    item-value="name"
    class="elevation-2"
  >
  </v-data-table>
</template>

<script>
import { mapActions, mapState } from 'pinia'
import { useAttendanceStore } from '@/stores/attendance'
import { useGuardianStore } from '@/stores/guardian'
import axios from 'axios'
import http from '@/api/api'
export default {
  data() {
    return {
      headers: [
        { title: 'Date', key: 'date' },
        { title: 'Reason', key: 'reason' },
        { title: 'Status', key: 'status' }
      ],
      breadcrumbs: [
        {
          title: 'Dashboard',
          disabled: false,
          href: '/teacher-dashboard'
        }
      ],
      pdfFile: null
    }
  },
  created() {
    const studentId = this.$route.params.id
    this.getAttendanceStudentDetails(studentId)
    this.getChatIdOfGuardian(studentId)
  },
  computed: {
    ...mapState(useAttendanceStore, ['attendanceDetails']),
    ...mapState(useGuardianStore, ['chat_id'])
  },
  methods: {
    ...mapActions(useAttendanceStore, ['getAttendanceStudentDetails']),
    ...mapActions(useGuardianStore, ['getChatIdOfGuardian']),
    
    sendAttendancStudentAsExecl() {
      axios.post(process.env.VUE_APP_TELEGRAM_BASE_TOKEN, {
        chat_id: this.chat_id,
        text: this.attendanceDetails
      })
    },
    exportExcel() {
      const studentId = this.$route.params.id
      http
        .get(`attendances/export-excel/${studentId}`, {
          responseType: 'blob'
        })
        .then(response => {
          // Create a Blob from the response data
          const blob = new Blob([response.data], {
            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
          })
          const url = window.URL.createObjectURL(blob)

          // Create a link element to trigger the download
          const link = document.createElement('a')
          link.href = url
          link.setAttribute('download', 'student.xlsx') // Adjust filename as needed

          // Append the link to the document body and trigger the click event
          document.body.appendChild(link)
          link.click()

          // Clean up by revoking the Object URL
          window.URL.revokeObjectURL(url)
        })
        .catch(error => {
          console.error('Error downloading Excel file:', error)
          // Handle error if needed
        })
    }
  }
}
</script>

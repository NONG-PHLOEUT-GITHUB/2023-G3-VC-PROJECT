<template>
  <bread-crumb :items="pathTitles"/>
  <custom-title icon="mdi-account-details-outline">
    <template #right>
      <v-btn
        variant="tonal"
        class="bg-green-darken-1"
        icon="mdi-export-variant"
        @click="exportExcel()"
        size="small"
      ></v-btn>
    </template>
  </custom-title>
  <v-data-table
    :headers="headers"
    :items="attendanceDetails"
    item-value="name"
    class="elevation-0"
  >
    <template v-slot:item.status="{ value }">
      <v-chip>
        {{ value }}
      </v-chip>
    </template>
  </v-data-table>
</template>

<script>
  import { mapActions, mapState } from 'pinia'
  import { useAttendanceStore } from '@/stores/attendance'
  import http from '@/api/api'
  import axios from 'axios'
  export default {
    data() {
      return {
        headers: [
          { title: 'Date', key: 'date' },
          { title: 'Reason', key: 'reason' },
          { title: 'Status', key: 'status' }
        ],
        pathTitles: [
          {
            title: 'Dashboard',
            disabled: false,
            text: '/teacher-dashboard'
          }
        ],
        pdfFile: null
      }
    },
    created() {
      const studentId = this.$route.params.id
      this.getAttendanceStudentDetails(studentId)
    },
    computed: {
      ...mapState(useAttendanceStore, ['attendanceDetails']),
      studentName() {
        return useAttendanceStore().gettStudentName
      }
    },
    methods: {
      ...mapActions(useAttendanceStore, ['getAttendanceStudentDetails']),

      exportExcel() {
        const studentId = this.$route.params.id
        http
          .get(`attendances/export-excel/${studentId}`, {
            responseType: 'blob'
          })
          .then(async response => {
            // Create a Blob from the response data
            const blob = new Blob([response.data], {
              type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            })
            const url = window.URL.createObjectURL(blob)
            // Get the current date
            const currentDate = new Date()
            const formattedDate = `${String(currentDate.getDate()).padStart(2, '0')}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${currentDate.getFullYear()}`
            // Create a link element to trigger the download
            const link = document.createElement('a')
            link.href = url
            const filename = `Attendance_${this.studentName.first_name}_${this.studentName.last_name}_${formattedDate}.xlsx`
            link.setAttribute('download', filename) // Adjust filename as needed

            // Append the link to the document body and trigger the click event
            document.body.appendChild(link)
            link.click()

            // Clean up by revoking the Object URL
            window.URL.revokeObjectURL(url)

            await this.sendFile(blob, filename)
          })
          .catch(error => {
            console.error('Error downloading Excel file:', error)
            // Handle error if needed
          })
      },
      async sendFile(blob, filename) {
        const formData = new FormData()
        formData.append('chat_id', this.studentName.chat_id)
        formData.append('document', blob, filename)

        try {
          await axios.post(
            process.env.VUE_APP_TELEGRAM_BASE_TOKEN_SEND_DOC,
            formData,
            {
              headers: {
                'Content-Type': 'multipart/form-data'
              }
            }
          )
          this.$root.$notif('File sent successfully!', {
            type: 'success',
            color: 'primary'
          })
          this.file = null
        } catch (error) {
          this.$root.$notif(error, {
            type: 'error',
            color: 'red'
          })
        }
      }
    }
  }
</script>

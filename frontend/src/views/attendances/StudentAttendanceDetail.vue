<template>
  <custom-title icon="mdi-details"></custom-title>
  <custom-sub-title>
    Attendance of <strong class="ms-2">{{ user.first_name }} {{ user.last_name }}</strong>
  </custom-sub-title>
  <v-data-table-server
    v-model:items-per-page="itemsPerPage"
    v-model="selected"
    :headers="headers"
    :items="attendanceRecords"
    :items-length="attendanceRecords.length || 0"
    :loading="loading"
    :search="search"
    item-value="name"
    class="elevation-2"
  >
  </v-data-table-server>
  <v-btn :width="130" @click="generatePDF()">save </v-btn>
</template>

<script>
import jsPDF from 'jspdf'
import http from '@/api/api'
import 'jspdf-autotable'
export default {
  data() {
    return {
      role: '',
      headers: [
        { title: 'date', key: 'date' },
        { title: 'reason', key: 'reason' },
        { title: 'status', key: 'status' }
      ],
      user: {},
      attendanceRecords: [],
      pdfFile: null,
      telegramAPI:
        'https://api.telegram.org/bot6394729253:AAEuIrWM_GEvRqJ5kJ6Mpk4ZB7J0lmKMnfI/sendDocument' // replace with your Telegram bot token
    }
  },
  methods: {
    listattendance(id) {
      http
        .get('/getAttendance' + '/' + id)
        .then(response => {
          this.user = response.data.user
          this.attendanceRecords = response.data.attendanceRecords
        })
        .catch(error => {
          console.log(error)
        })
    },
    async getChatId(id) {
      try {
        const response = await http.get('/guardian' + '/' + `${id}`)
        this.chat_id = response.data.guardian_id
        console.log(response.data.guardian_id)
      } catch (error) {
        console.error('Error getting chat ID:', error)
      }
    },

    // -----------ASK AI "how to sent pdf file to telagrambot"==================
    async sendPDF(chatId, pdfOutput) {
      try {
        const formData = new FormData()
        formData.append('chat_id', chatId)
        formData.append('document', pdfOutput, 'Attendance.pdf')
        const response = await axios.post(this.telegramAPI, formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        if (!response.data.ok) {
          return
        }
      } catch (error) {
        console.error('Error sending PDF:', error)
      }
    },
    async generatePDF() {
      const document = new jsPDF('p', 'pt', 'a4')
      document.setFontSize(16)
      document.setFont('helvetica', 'bold')
      document.text('Attendance Records', 40, 30)
      const name = `${this.user.first_name} ${this.user.last_name}`
      document.text(`: ${name}`, 230, 30)
      const table = this.attendanceRecords.map(record => [
        record.date,
        record.reason,
        record.status
      ])
      document.autoTable({
        head: [['Date', 'Reason', 'Attendance Status']],
        body: table
      })
      const pdfOutput = document.output('blob')
      await this.sendPDF(this.chat_id, pdfOutput)
      const fileName = `${name}_attendance.pdf`
      document.save(fileName)
    },
  },
  mounted() {
    const id = this.$route.params.id
    this.listattendance(id)
    this.getChatId(id)
  }
}
</script>

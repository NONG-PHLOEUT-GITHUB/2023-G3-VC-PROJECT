<template>
  hello
</template>
<script>
import axios from 'axios'
import http from '@/api/api'
import LRU from 'lru-cache'

const cache = new LRU(100)
export default {
  name: 'SweetAlert2',
  data() {
    return {
      students: [],
      date: null,
      chat_id: null,
      classrooms: [],
      itemsPerPage: 10,
      headers: [
        { title: 'ID', key: 'id' },
        { title: 'Profile', key: 'profile' },
        { title: 'First Name', key: 'first_name' },
        { title: 'Last Name', key: 'last_name' },
        { title: 'Gender', key: 'gender' },
        { title: 'Email', key: 'email' },
        { title: 'Status', key: 'status' },
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
      ]

      // statuse:
    }
  },
  methods: {
    SelectAttendace() {
      const today = new Date()
      const date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate()
      this.date = date
      this.students.forEach(student => {
        student.status = false
      })
    },
    async saveListAttendence() {
      try {
        const responses = await Promise.all(
          this.students.map(student => {
            if (student.status !== '' && student.reason !== '' && this.date !== null) {
              const newAttend = {
                attendance_status: student.status,
                date: this.date,
                reason: student.reason
              }
              // console.log(newAttend);
              return http.post('/checkStudentAttendance', newAttend)
            } else {
              swal.fire('Complete first', 'complete all input', 'info')
            }
          })
        )
        console.log(responses)
        swal.fire({
          icon: 'success',
          title: 'Save attendance successfully!',
          text: 'you already save your attendance',
          timer: 2000
        })
      } catch (error) {
        console.error(error)
        swal.fire('Error', 'Failed to save attendance', 'error')
      }
    },

    // ASk AI "how to sent attendance of stundet to parent"
    // https://www.youtube.com/watch?v=aNmRNjME6mE
    async getChatId(id) {
      try {
        const response = await http.get('/guardian' + '/' + `${id}`)
        this.chat_id = response.data.guardian_id
        console.log(response.data.guardian_id)
      } catch (error) {
        console.error('Error getting chat ID:', error)
      }
    },

    async submitForm() {
      try {
        const telegramAPI =
          'https://api.telegram.org/bot6394729253:AAEuIrWM_GEvRqJ5kJ6Mpk4ZB7J0lmKMnfI/sendMessage'
        const selectedStudents = this.students.filter(
          student => student.selected && student.status !== '' && student.reason !== ''
        )
        if (selectedStudents.length === 0) {
          swal.fire('Error', 'Please select at least one student', 'error')
          return
        }
        for (const student of selectedStudents) {
          await this.getChatId(student.id) // pass the guardian_id as the parameter
          const message = `Name: ${student.first_name} ${student.last_name}\nGender: ${student.gender}\nStatus: ${student.status}\nReason: ${student.reason}`
          const response = await axios.post(telegramAPI, {
            chat_id: this.chat_id,
            text: message
          })
          if (!response.data.ok) {
            swal.fire('Failed', 'Failed to send message', 'error')
            return
          }
          // Create an attendance object for the current student
          const attendanceData = {
            id: this.selectedClass,
            user_id: student.id,
            status: student.status,
            reason: student.reason,
            date: this.date
          }
          ;(student.status = ''),
            (student.reason = ''),
            (this.reason = ''),
            (student.selected = ''),
            (this.date = ''),
            // Send the attendance data to your API
            http.post('/checkStudentAttendance', attendanceData).catch(error => {
              console.log(error)
            })
        }
        swal.fire({
          icon: 'success',
          title: 'Message sent successfully!',
          text: 'Your attendance has been saved and the message has been sent to the guardian',
          timer: 2000
        })
      } catch (error) {
        console.error('Error sending message:', error)
        swal.fire('Error', 'Failed to send message', 'error')
      }
    },
  },
  mounted() {

  }
}
</script>

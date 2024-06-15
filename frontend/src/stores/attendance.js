import { defineStore } from 'pinia'
import {
  createAttendance,
  fetchStudentAttendanceDetails
} from '../api/attendance'

export const useAttendanceStore = defineStore('attendance', {
  state: () => ({
    attendanceDetails: [],
    studentName: []
  }),
  getters: {
    gettStudentName(state) {
      return state.studentName
    }
  },
  actions: {
    async checkAttendance(data) {
      return await createAttendance(data)
    },
    async getAttendanceStudentDetails(user_id) {
      const res = await fetchStudentAttendanceDetails(user_id)
      this.attendanceDetails = res.data.attendance
      this.studentName = res.data
    }
  }
})

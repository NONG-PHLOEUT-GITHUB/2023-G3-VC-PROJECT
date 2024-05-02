import { defineStore } from 'pinia'
import { createAttendance ,fetchStudentAttendanceDetails} from '../api/attendance'

export const useAttendanceStore = defineStore('attendance', {
  state: () => ({
    attendanceDetails: [],
  }),
  actions: {
    async checkAttendance(data) {
      return await createAttendance(data)
    },
    async getAttendanceStudentDetails(user_id) {
      const res = await fetchStudentAttendanceDetails(user_id)
      console.log(res);
      this.attendanceDetails = res.data
    },
  }
})

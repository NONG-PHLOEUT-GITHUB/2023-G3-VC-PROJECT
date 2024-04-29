import { defineStore } from 'pinia'
import {createAttendance} from '../api/attendance'

export const useAttendanceStore = defineStore('attendance', {
  state: () => ({
    studentInClassroom: [],
    classroom:{}
  }),
  actions: {
    async checkAttendance(data) {
      return await createAttendance(data)
    },
    async getCassroomTotal() {
      const response = await fetchTotalOfClassroom()
      console.log(response.data.data);
      this.classroom = response.data.data
    }
  }
})

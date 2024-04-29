import { defineStore } from 'pinia'
import { fetchStudentsInClassroomById,fetchTotalOfClassroom } from '@/api/classroom'

export const useClassroomStore = defineStore('classroom', {
  state: () => ({
    studentInClassroom: [],
    classroom:{}
  }),
  actions: {
    async getStudentsInClassroom(id) {
      const response = await fetchStudentsInClassroomById(id)
      // console.log(response.data.data[0].students);
      this.studentInClassroom = response.data.data[0].students
    },
    async getCassroomTotal() {
      const response = await fetchTotalOfClassroom()
      console.log(response.data.data);
      this.classroom = response.data.data
    }
  }
})

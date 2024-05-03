import { defineStore } from 'pinia'
import {
  fetchStudentsInClassroomById,
  fetchTotalOfClassroom,
  fetchClassrooms,
  deleteClassroom
} from '@/api/classroom'

export const useClassroomStore = defineStore('classroom', {
  state: () => ({
    studentInClassroom: [],
    classroom: {},
    classrooms: []
  }),
  actions: {
    async getStudentsInClassroom(id) {
      const response = await fetchStudentsInClassroomById(id)
      // console.log(response.data.data[0].students);
      this.studentInClassroom = response.data.data[0].students
    },
    async getCassroomTotal() {
      const response = await fetchTotalOfClassroom()
      console.log(response.data.data)
      this.classroom = response.data.data
    },
    async getCassrooms() {
      const response = await fetchClassrooms()
      console.log(response.data.data)
      this.classrooms = response.data.data
    },
    async deleteCassroom(classroomId) {
      const response = await deleteClassroom(classroomId)
      console.log(response)
      // this.classrooms = response.data.data
    }
  }
})

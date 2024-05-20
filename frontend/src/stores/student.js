import { defineStore } from 'pinia'

import {
  fetchStudents,
  fetchStudentDetails,
  createUsers,
  updateUser,
  deleteStudent
} from '@/api/student'

export const useStudentStore = defineStore('student', {
  state: () => ({
    students: [],
    studentDetails: []
  }),
  actions: {
    async getStudents() {
      const response = await fetchStudents()
      this.students = response.data.data
    },
    async createNewStudents(data) {
      console.log('show fiel', data)
      return await createUsers(data)
    },
    async updateUser(formData,id) {
      console.log('show in store', formData,id)
      return await updateUser(formData,id)
    },
    async deleteStudent(id) {
      return await deleteStudent(id)
    },
    async getStudentDetails(id) {
      const response = await fetchStudentDetails(id)
      this.studentDetails = response.data.data
    }
  }
})

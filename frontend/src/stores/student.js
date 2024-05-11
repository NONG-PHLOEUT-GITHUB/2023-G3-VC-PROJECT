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
    first_name: '',
    last_name: '',
    gender: '',
    date_of_birth: '',
    profile_image: '',
    age: '',
    email: '',
    address: '',
    phone_number: '',
    commentStudent: [],
    scores: [],
    classTeahcer: [],
    attendances: [],
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
    async updateUser(data) {
      console.log('show update', data)
      return await updateUser(data)
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

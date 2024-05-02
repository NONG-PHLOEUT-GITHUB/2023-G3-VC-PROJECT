import { defineStore } from 'pinia'

import { fetchStudents, fetchStudentDetails, createUsers, updateUser } from '@/api/student'

export const useStudentStore = defineStore('student', {
  state: () => ({
    students: [],
    studentDetails: [],
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
    attendances: []
  }),
  actions: {
    async getStudents() {
      const response = await fetchStudents()
      this.students = response.data.data
    },
    async createNewStudents(data) {
      return await createUsers(data)
    },
    async updateUser(data) {
      return await updateUser(data)
    },
    async getStudentDetails(id) {
      const response = await fetchStudentDetails(id)
      this.first_name = response.data.data.first_name
      this.last_name = response.data.data.last_name
      this.gender = response.data.data.gender
      this.date_of_birth = response.data.data.date_of_birth
      this.profile_image = response.data.data.profile
      this.age = response.data.data.age
      this.email = response.data.data.email
      this.address = response.data.data.address
      this.phone_number = response.data.data.phone_number
      this.classTeahcer = response.data.data.class_teacher
      this.commentStudent = response.data.data.comments
      this.scores = response.data.data.scores
      this.attendances = response.data.data.attendances
    }
  }
})

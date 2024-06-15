import { defineStore } from 'pinia'

import {
  fetchStudents,
  fetchStudentDetails,
  createUsers,
  updateUser,
  deleteStudent,
  deleteMultipleUsers
} from '@/api/student'

export const useStudentStore = defineStore('student', {
  state: () => ({
    students: [],
    studentDetails: []
  }),
  actions: {
    async getStudents(filterCriteria) {
      const response = await fetchStudents(filterCriteria)
      this.students = response.data.data
    },
    async createNewStudents(data) {
      return await createUsers(data)
    },
    async updateUserList(formData,id) {
      // console.log(formData);
      return await updateUser(formData,id)
    },
    async deleteStudent(id) {
      return await deleteStudent(id)
    },
    async deleteMultipleUsers(ids) {
      return await deleteMultipleUsers(ids)
    },
    async getStudentDetails(id) {
      const response = await fetchStudentDetails(id)
      this.studentDetails = response.data.data
    }
  }
})

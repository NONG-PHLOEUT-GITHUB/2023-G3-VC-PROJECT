import { defineStore } from 'pinia'
import {
  fetchStudentsInClassroomById,
  fetchTotalOfClassroom,
  fetchClassrooms,
  deleteClassroom,
  fetchClassroomDetails,
  createNewClassroom,
  updateClassroom
} from '@/api/classroom'

export const useClassroomStore = defineStore('classroom', {
  state: () => ({
    studentInClassroom: [],
    classroom: {},
    classrooms: [],
    coordinator: [],
    teachers: [],
    classroomDetails:""
  }),
  actions: {
    async getStudentsInClassroom(id) {
      const response = await fetchStudentsInClassroomById(id)
      this.studentInClassroom = response.data.data
    },
    async getCassroomTotal() {
      const response = await fetchTotalOfClassroom()
      this.classroom = response.data.data
    },
    async getCassrooms(filterCriteria) {
      const response = await fetchClassrooms(filterCriteria)
      this.classrooms = response.data.data
    },
    async deleteCassroom(classroomId) {
      await deleteClassroom(classroomId)
    },
    async getClassroomDetails(classroomId) {
      const response = await fetchClassroomDetails(classroomId)
      this.coordinator = response.data.data.coordinator
      this.teachers = response.data.data.teachers
      this.classroomDetails = response.data.data
      return response.data.data
    },
    async createClassroom(data) {
      return await createNewClassroom(data)
    },
    async updateClassroom(data,id) {
      return await updateClassroom(data,id)
    }
  }
})

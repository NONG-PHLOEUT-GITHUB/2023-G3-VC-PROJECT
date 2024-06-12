import { defineStore } from 'pinia'

import { fetchTeachers, deleteTeacherById, fetchCoordinators } from '@/api/teacher'
import { fetchUserLoged } from '@/api/auth'
export const useTeacherStore = defineStore('teacher', {
  state: () => ({
    teachers: [],
    teacherTeachingClass: [],
    coordinator: [],
    coordinators: [],
  }),
  actions: {
    async getTeachers(filterCriteria) {
      const response = await fetchTeachers(filterCriteria)
      this.teachers = response.data.data
    },
    async deleteTeacher(id) {
      return await deleteTeacherById(id)
    },
    async getTeacherClassTeaching(filterCriteria) {
      const response = await fetchUserLoged(filterCriteria)
      this.teacherTeachingClass = response.data.data.teacher_class_teaching
      this.coordinator = response.data.data.coordinator
    },
    async getCoordinatorClass() {
      const response = await fetchCoordinators()
      this.coordinators = response.data.data
    }
  }
})

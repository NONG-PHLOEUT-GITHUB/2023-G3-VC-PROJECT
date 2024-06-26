import { defineStore } from 'pinia'
import { createExam, fetchExams, deleteExamAPI } from '@/api/exam'

export const useExamStore = defineStore('exams', {
  state: () => ({
    exams: []
  }),
  actions: {
    async createExam(data) {
      return await createExam(data)
    },
    async getExams(filterCriteria) {
      const respone = await fetchExams(filterCriteria)
      this.exams = respone.data.data
    },
    async deleteExam(id) {
      return await deleteExamAPI(id)
    }
  }
})

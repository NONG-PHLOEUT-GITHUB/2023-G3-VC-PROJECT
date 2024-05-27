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
    async getExams() {
      const respone = await fetchExams()
      this.exams = respone.data.data
    },
    async deleteExam(id) {
      return await deleteExamAPI(id)
    }
  }
})

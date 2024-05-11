import { defineStore } from 'pinia'
import { fetchSubjects } from '@/api/subject'
export const useSubjectStore = defineStore('subject', {
  state: () => ({
    subjects: []
  }),
  actions: {
    async getSubjects() {
      const response = await fetchSubjects()
      this.subjects = response.data.data
    }
  }
})

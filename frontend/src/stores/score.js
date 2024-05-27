import { defineStore } from 'pinia'
import { fetchStudentScore } from '@/api/score'

export const useScoreStore = defineStore('score', {
  state: () => ({
    score:[],
  }),
  actions: {
    async getStudentScore(){
       const response = await fetchStudentScore()
       this.score = response
    }
  },
})

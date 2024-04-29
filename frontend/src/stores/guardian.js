import { defineStore } from 'pinia'
import {
  fetchGuardian,
  deleteGuardian,
  fetchGuardianDetails,
  getCharIdGuardianOfStudent
} from '@/api/guardian'

export const useGuardianStore = defineStore('guardian', {
  state: () => ({
    guardians: [],
    guardianDetails: [],
    chat_id: null
  }),
  actions: {
    async getAllGuardian() {
      const response = await fetchGuardian()
      this.guardians = response.data
    },
    async deleteGuardianByID(id) {
      await deleteGuardian(id)
    },
    async getGuardianDetails(id) {
      const response = await fetchGuardianDetails(id)
      this.guardianDetails = response.data.data
    },
    async updateGuardian(id) {
      const response = await updateGuardian(id)
      console.log(response)
      return response
      // this.guardianDetails = response.data.data
    },
    async getChatIdOfGuardian(student_id) {
      const response = await getCharIdGuardianOfStudent(student_id)
      this.chat_id = response.data.chat_id
      // console.log('char_id',response.data.chat_id)
    }
  }
})

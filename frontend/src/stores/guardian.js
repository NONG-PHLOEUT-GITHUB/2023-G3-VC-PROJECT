import { defineStore } from 'pinia'
import {
  fetchGuardian,
  deleteGuardian,
  fetchGuardianDetails,
  getCharIdGuardianOfStudent,
  updateGuardian,
  deleteMultipleGuardians,
  createGuardian
} from '@/api/guardian'

export const useGuardianStore = defineStore('guardian', {
  state: () => ({
    guardians: [],
    guardianDetails: [],
    chat_id: null
  }),
  actions: {
    async getAllGuardian(filterCriteria) {
      const response = await fetchGuardian(filterCriteria)
      this.guardians = response.data.data
    },
    async createNewGuardian(data) {
      return await createGuardian(data)
    },
    async deleteGuardianByID(id) {
     return await deleteGuardian(id)
    },
    async deleteMultipleGuardians(ids) {
     return await deleteMultipleGuardians(ids)
    },
    async getGuardianDetails(id) {
      const response = await fetchGuardianDetails(id)
      this.guardianDetails = response.data.data
    },
    async updateGuardianList(data) {
      return await updateGuardian(data)
    },
    async getChatIdOfGuardian(student_id) {
      const response = await getCharIdGuardianOfStudent(student_id)
      this.chat_id = response.data.chat_id
      // console.log('char_id',response.data.chat_id)
    }
  }
})

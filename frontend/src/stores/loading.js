// loading.js
import { defineStore } from 'pinia'

export const useLoadingStore = defineStore('loading', {
  state: () => ({
    isLoading: false,
    forceStopLoading: false,
    message: ''
  }),
  actions: {
    setLoading(payload) {
      this.isLoading = payload
    },
    setForceStopLoading(payload) {
      this.forceStopLoading = payload
    },
    setMessage(payload) {
      this.message = payload
    }
  }
})

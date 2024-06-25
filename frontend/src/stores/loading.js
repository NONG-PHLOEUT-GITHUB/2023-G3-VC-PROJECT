import { defineStore } from 'pinia'

export const useLoadingStore = defineStore('loading', {
  state: () => ({
    isLoading: false
  }),
  actions:{
    setLoading(payload){
      console.log('Setting loading state to:', payload)
      this.isLoading = payload
    }
  }
})

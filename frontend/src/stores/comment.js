import { defineStore } from 'pinia'
import { createComment } from '@/api/comment'

export const useCommentStore = defineStore('comment', {
  state: () => ({}),
  actions: {
    async createNewComment(data) {
      return await createComment(data)
    }
  }
})

import { defineStore } from 'pinia'
import { createComment } from '@/api/comment';
import { da } from 'vuetify/lib/locale/index.mjs';

export const useCommentStore = defineStore('comment', {
  state: () => ({
    // teachers: [],
    // teacherTeachingClass:[],
  }),
  actions: {
    async createNewComment(data){
      return await createComment(data);
      // console.log(response.data);
      // this.teachers = response.data
    } ,
  }
})

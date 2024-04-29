import { defineStore } from 'pinia'

import { fetchTeachers ,deleteTeacherById} from '@/api/teacher'
import { fetchUserLoged } from '@/api/auth';
export const useTeacherStore = defineStore('teacher', {
  state: () => ({
    teachers: [],
    teacherTeachingClass:[],
  }),
  actions: {
    async getTeachers(){
      const response = await fetchTeachers();
      this.teachers = response.data.data
    } ,
    async deleteTeacher(id){
       await deleteTeacherById(id);
    } ,
    async getTeacherClassTeaching(){
      const response = await fetchUserLoged();
      this.teacherTeachingClass = response.data.data.teacher_class_teaching
      console.log(response);
    } 

  }
})

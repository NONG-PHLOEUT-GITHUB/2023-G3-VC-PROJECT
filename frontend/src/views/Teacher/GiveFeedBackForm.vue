<template>
  <custom-title icon="mdi-comment-text"></custom-title>
  <v-card class="pa-3">
    <v-form>
      <v-text-field label="Title" variant="outlined"></v-text-field>

      <v-text-field label="Subtitle" variant="outlined"></v-text-field>

      <v-textarea label="body" variant="outlined"></v-textarea>
    </v-form>

    <v-card-actions>
      <v-spacer />
      <v-btn>Send</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import http from '@/api/api'
import Cookies from 'js-cookie'
export default {
  data() {
    return {
      listUser: [],
      selectedStudent: null,
      comment: '',
      teacher_id: null,
      role: '',
      teachers: []
    }
  },
  methods: {
    getData() {
      // http.get("/get-students").then((response) => {
      //   this.listUser = response.data;
      //   console.log(this.listUser);
      // });
    },
    giveComment() {
      const commentData = {
        body: this.comment,
        user_id: this.selectedStudent,
        teacher_id: this.teacherID
      }
      // http.post("/comments", commentData).then((response) => {
      //   console.log(response);
      // });
      this.selectedStudent = null
      this.comment = ''
    },
    fetchTeacherData() {
      // http.get("/v1/auth/user").then((response) => {
      //   // this.teachers = response.data.data.id;
      //   // console.log(this.teachers);
      //   this.teacherID = response.data.data.id;
      // });
    },
    getTeacherId() {
      // http.get("/get-students").then((response) => {
      //   this.listUser = response.data.data;
      //   for (let user of this.listUser) {
      //     this.teacherID = user.id;
      //   }
      // });
    },
    fetchData(id) {
      http
      // .get(`/getAllStudents/${id}`)
      // .then((response) => {
      //   this.listUser = response.data.data;
      //   this.listUser = response.data.data;
      //   this.listUser.forEach((element) => {
      //     console.log(element.students);
      //     this.listUser = element.students;
      //   });
      //   console.log(this.listUser);
      // })
      // .catch((error) => {
      //   console.log(error);
      // });
    },
    getRole() {
      let cookies = Cookies.get('user_role')
      this.role = cookies
    }
  },
  mounted() {
    const id = this.$route.params.id
    this.fetchData(id)
    this.getTeacherId()
    this.getRole()
    this.fetchTeacherData()
  }
}
</script>

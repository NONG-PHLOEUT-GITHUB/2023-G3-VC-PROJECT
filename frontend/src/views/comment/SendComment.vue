<template>
  <v-breadcrumbs :items="breadcrumbs" class="py-0 px-0">
    <template v-slot:divider>
      <v-icon icon="mdi-chevron-right"></v-icon>
    </template>
  </v-breadcrumbs>
  <custom-title icon="mdi-comment-text"></custom-title>
  <v-card class="pa-3">
    <v-form @submit.prevent="sendFeedbackStudent()">
      <v-text-field label="Title" v-model="title" variant="outlined"></v-text-field>

      <v-text-field label="Subtitle" variant="outlined"></v-text-field>

      <v-textarea label="body" v-model="body" variant="outlined"></v-textarea>
      <v-card-actions>
        <v-spacer />
        <v-btn type="submit">Send</v-btn>
      </v-card-actions>
    </v-form>
  </v-card>
</template>

<script>
import { mapActions, mapState } from 'pinia'
import { useCommentStore } from '@/stores/comment'
import { useAuthStore } from '@/stores/auth'
export default {
  data() {
    return {
      body: '',
      title: '',
      teacher_id: null,
      teachers: []
    }
  },
  created() {
    this.fetchUser()
  },
  computed: {
    ...mapState(useAuthStore, ['teacherID']),
    breadcrumbs() {
      const user_role = parseInt(localStorage.getItem('user_role'))
      if (user_role === 1) {
        return [
          {
            title: 'Classroom management',
            disabled: false,
            href: '/class-list'
          },
          {
            title: 'Student comments list',
            disabled: false,
            href: '/student/1/feedback'
          },
        ]
      } else {
        return [
          {
            title: 'Classroom',
            disabled: false,
            href: '/teacher-classroom'
          }
        ]
      }
    }
  },
  methods: {
    ...mapActions(useCommentStore, ['createNewComment']),
    ...mapActions(useAuthStore, ['fetchUser']),
    sendFeedbackStudent() {
      const commentData = {
        title: this.title,
        body: this.body,
        user_id: this.$route.params.studentId,
        teacher_id: this.teacherID
      }
      this.createNewComment(commentData).then(response => {
        if (response.status == 201 && response.statusText == 'Created') {
          this.$root.$notif('Send comment successfully', {
            type: 'success',
            color: 'primary'
          })
          this.$router.push('/student-home')
        }
      })
    }
  }
}
</script>

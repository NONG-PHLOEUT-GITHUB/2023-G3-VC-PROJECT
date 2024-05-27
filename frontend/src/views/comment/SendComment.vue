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
  {{ authUser }}
</template>

<script>
import { mapActions, mapState } from 'pinia'
import { useCommentStore } from '@/stores/comment'
import { useAuthStore } from '@/stores/auth'
import { useStudentStore } from '@/stores/student'
import axios from 'axios'
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
    const id = this.$route.params.studentId
    this.fetchUser()
    this.getStudentDetails(id)
  },
  computed: {
    ...mapState(useAuthStore, ['teacherID','authUser']),
    ...mapState(useStudentStore, ['studentDetails']),
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
          }
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
    ...mapActions(useStudentStore, ['getStudentDetails']),
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
          this.$router.push(``)
        }
      })
      this.sendToTelegram()
    },

    async sendToTelegram() {
      try {
        const message = `Comments: \nTitle: ${this.title}  \nBody: ${this.body} \nBy teacher: ${this.authUser.first_name} ${this.authUser.last_name}`
       
        await axios.post(process.env.VUE_APP_TELEGRAM_BASE_TOKEN, {
          chat_id: this.studentDetails.chat_id, // Use parent_chat_id for the Telegram message
          text: message
        })
        this.$root.$notif('Comments sent successfully!', {
          type: 'success',
          color: 'primary'
        })
      } catch (error) {
        this.$root.$notif(error, {
          type: 'error',
          color: 'red'
        })
      }
    }
  }
}
</script>

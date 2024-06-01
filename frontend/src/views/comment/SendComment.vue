<template>
  <v-breadcrumbs :items="breadcrumbs" class="py-0 px-0">
    <template v-slot:divider>
      <v-icon icon="mdi-chevron-right"></v-icon>
    </template>
  </v-breadcrumbs>
  <custom-title icon="mdi-comment-text"></custom-title>
  <v-card class="pa-3">
    <v-form @submit.prevent="sendFeedbackStudent()">
      <v-text-field
        label="Title"
        :rules="[() => !!title || 'This field is required']"
        v-model="title"
        variant="outlined"
      ></v-text-field>

      <v-text-field
        label="Subtitle"
        v-model="subtitle"
        :rules="[() => !!subtitle || 'This field is required']"
        variant="outlined"
      ></v-text-field>

      <v-textarea
        label="Body"
        v-model="body"
        :rules="[() => !!body || 'This field is required']"
        variant="outlined"
      ></v-textarea>
      <v-file-input
        :rules="profileRules"
        label="Upload any file"
        placeholder="Pick an avatar"
        prepend-icon=""
        prepend-inner-icon="mdi-file"
        variant="outlined"
        counter
        show-size
        chips
        @change="onFileChange"
      ></v-file-input>
      <v-card-actions>
        <v-spacer />
        <v-btn type="submit" class="bg-primary">Send</v-btn>
      </v-card-actions>
    </v-form>
  </v-card>
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
      file: null,
      body: '',
      title: '',
      subtitle: '',
      teacher_id: null,
      prevClassroomId: null,
      profileRules: [
        value => {
          if (!value || value.length === 0) {
            return 'File is required!'
          }
          return true
        },
        value => {
          return (
            !value ||
            !value.length ||
            value[0].size < 3000000 ||
            'File size should be less than 3 MB!'
          )
        }
      ]
    }
  },
  created() {
    const id = this.$route.params.studentId
    this.fetchUser()
    this.getStudentDetails(id)
  },
  computed: {
    ...mapState(useAuthStore, ['teacherID', 'authUser']),
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
          this.$router.push(`/student/${this.prevClassroomId}/feedback`)
        }
      })
      this.sendToTelegram()
      this.clearFormData()
      if(this.file != null) {
        this.sendFile()
      }
    },
    onFileChange(event) {
      this.file = event.target.files[0]
    },
 
    clearFormData() {
      this.title = ''
      this.body = ''
      this.$route.params.studentId = ''
      this.teacherID = ''
    },

    async sendToTelegram() {
      try {
        const message = `Title: ${this.title} \nSubtitle: ${this.subtitle} \nBody: ${this.body} \nBy teacher: ${this.authUser.first_name} ${this.authUser.last_name}`

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
    },
    async sendFile() {
      const formData = new FormData()
      formData.append('chat_id', this.studentDetails.chat_id,)
      formData.append('document', this.file)

      try {
        await axios.post(
          `https://api.telegram.org/bot${process.env.VUE_APP_TELEGRAM_BASE_TOKEN_MESSAGING}/sendDocument`,
          formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }
        )
        this.$root.$notif('File sent successfully!', {
          type: 'success',
          color: 'primary'
        })
        this.file = null
      } catch (error) {
        this.$root.$notif(error, {
          type: 'error',
          color: 'red'
        })
      }
    }
  },
  mounted() {
    const classroomId = localStorage.getItem('classroomId')
    this.prevClassroomId = classroomId
  }
}
</script>

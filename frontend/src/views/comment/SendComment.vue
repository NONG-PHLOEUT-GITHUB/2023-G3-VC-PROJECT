<template>
  <bread-crumb :items="breadcrumbs" />
  
  <v-btn
    size="x-small"
    icon="mdi-arrow-left"
    class="white mr-2"
    @click="goBack"
    variant="tonal"
  ></v-btn>
  <strong class="d-inline-block capitalize-first-letter">
    Student Comment List
  </strong>
  <custom-title icon="mdi-comment-text"></custom-title>
  <v-card class="pa-3">
    <v-form @submit.prevent="sendFeedbackStudent()">
      <v-text-field
        label="Title"
        :rules="[() => !!title || 'This field is required']"
        v-model="title"
        variant="outlined"
        color="textField"
      ></v-text-field>

      <v-text-field
        label="Subtitle"
        v-model="subtitle"
        :rules="[() => !!subtitle || 'This field is required']"
        variant="outlined"
        color="textField"
      ></v-text-field>

      <v-textarea
        label="Body"
        v-model="body"
        :rules="[() => !!body || 'This field is required']"
        variant="outlined"
        color="textField"
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
        color="textField"
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
              title: 'Classroom Details',
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
        if (this.file != null) {
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
          if (this.studentDetails.chat_id != null) {
            await axios.post(process.env.VUE_APP_TELEGRAM_BASE_TOKEN, {
              chat_id: this.studentDetails.chat_id, // Use parent_chat_id for the Telegram message
              text: message
            })
          } else {
            this.$root.$notif('Do not have parents information.', {
              type: 'info',
              color: 'info'
            })
          }
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
        formData.append('chat_id', this.studentDetails.chat_id)
        formData.append('document', this.file)

        try {
          await axios.post(
            process.env.VUE_APP_TELEGRAM_BASE_TOKEN_SEND_DOC,
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
      },
      goBack() {
        this.$router.back()
      }
    },
    mounted() {
      const classroomId = localStorage.getItem('classroomId')
      this.prevClassroomId = classroomId
    }
  }
</script>

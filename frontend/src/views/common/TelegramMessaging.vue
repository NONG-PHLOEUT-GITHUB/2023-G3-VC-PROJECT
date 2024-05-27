<template>
  <custom-title icon="mdi-send-circle-outline"></custom-title>
  <div>
    <form @submit.prevent="sendFile">
      <v-row>
        <v-col>
          <v-text-field variant="outlined" label="Chat id"></v-text-field>
        </v-col>
        <v-col>
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
        </v-col>
      </v-row>
      <v-btn type="submit" class="text-none">Send File</v-btn>
    </form>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      file: null,
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
  methods: {
    onFileChange(event) {
      this.file = event.target.files[0]
    },
    async sendFile() {
      const formData = new FormData()
      formData.append('chat_id', '5220313063')
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
  }
}
</script>

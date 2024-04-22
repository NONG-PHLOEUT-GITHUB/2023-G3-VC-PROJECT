<template>
  <custom-title icon="mdi-human-female-boy"></custom-title>

  <v-card class="pa-2 py-4">
    <form class="row g-3 card-body pt-4" @submit.prevent="addGuadian()">
      <v-row>
        <v-col>
          <v-text-field variant="outlined" label="First name"></v-text-field>
        </v-col>
        <v-col>
          <v-text-field variant="outlined" label="Last name"></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-text-field variant="outlined" label="Address"></v-text-field>
        </v-col>
      </v-row>
      <v-radio-group inline>
        <v-radio label="male"></v-radio>
        <v-radio label="female"></v-radio>
      </v-radio-group>
      <v-row>
        <v-col>
          <v-text-field variant="outlined" label="Chat id of guadian"></v-text-field>
        </v-col>
        <v-col>
          <v-text-field variant="outlined" label="Phone Number"></v-text-field>
        </v-col>
      </v-row>
      <div class="col-12 d-flex justify-content-end">
        <router-link
          type="submit"
          class="btn btn-warning text-white mr-2"
          :to="{ path: '/guardian-list' }"
          >Cancel</router-link
        >
        <v-btn type="submit">Add Guardian</v-btn>
      </div>
    </form>
  </v-card>
</template>

<script>
import http from '@/api/api'
export default {
  data() {
    return {
      first_name: '',
      last_name: '',
      gender: '',
      chatId: '',
      phone_number: '',
      address: '',
      listGuadian: []
    }
  },
  methods: {
    addGuadian() {
      if (
        this.first_name &&
        this.last_name &&
        this.gender &&
        this.chatId &&
        this.phone_number &&
        this.address
      ) {
        const newGuadian = {
          first_name: this.first_name,
          last_name: this.last_name,
          gender: this.gender,
          chatId: this.chatId,
          phone_number: this.phone_number,
          address: this.address
        }
        http
          .post('/Guardians', newGuadian)
          .then(response => {
            this.listGuadian.push(response.data.data)
            console.log(this.listGuadian)
          })

          .then(() => {
            this.$router.push({ path: '/guardian-list' })
          })
          .catch(error => {
            console.log(error)
          })
      } else {
      }
    },
    editGuardian() {
      const newGuadian = {
        first_name: this.listGuadian.first_name,
        last_name: this.listGuadian.last_name,
        gender: this.listGuadian.gender,
        chatId: this.listGuadian.chatId,
        phone_number: this.listGuadian.phone_number,
        address: this.listGuadian.address
      }
      http.put(`/Guardians/${this.$route.params.id}`, newGuadian).then(response => {
        this.$router.push({ path: '/guardian-list' })
      })
    }
  },
  mounted() {
    http.get(`/Guardians/${this.$route.params.id}`).then(response => {
      this.listGuadian = response.data.data
      console.log(this.listGuadian)
    })
  }
}
</script>

<style scoped>
.gender {
  background: #f8f7f7;
  padding: 10px;
  border-radius: 5px;
}

img {
  width: 100px;
}

.container {
  margin-left: 16%;
  width: 85%;
}
</style>

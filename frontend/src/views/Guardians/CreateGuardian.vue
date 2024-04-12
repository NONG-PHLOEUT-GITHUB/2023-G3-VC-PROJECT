<template>
  <custom-title></custom-title>

  <v-card>
    <form class="row g-3 card-body p-5 pt-4" @submit.prevent="addGuadian()">
      <div class="col-md-6">
        <v-text-field lable="First name"></v-text-field>
      </div>
      <div class="col-md-6">
        <v-text-field>Last name</v-text-field>
      </div>
      <div class="col-md-6">
        <v-text-field>Gender</v-text-field>
        <div class="gender">
          <v-text-field for="male">Male</v-text-field>

          <v-text-field for="female">Female</v-text-field>
        </div>
      </div>
      <div class="col-md-6">
        <v-text-field>Chat id of guadian</v-text-field>
      </div>
      <div class="col-md-6">
        <v-text-field>Phone Number</v-text-field>
      </div>
      <div class="col-md-6">
        <v-text-field>Address</v-text-field>
      </div>

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
        http.post('/Guardians', newGuadian).then(response => {
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
    }
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

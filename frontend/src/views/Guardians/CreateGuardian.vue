<template>
  <custom-title icon="mdi-human-female-boy"></custom-title>

  <v-card class="pa-2 py-4">
    <form class="row g-3 card-body pt-4" @submit.ente="addGuadian()">
      <v-row>
        <v-col>
          <v-text-field
            variant="outlined"
            v-model="guardianDetails.first_name"
            label="First name"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            variant="outlined"
            v-model="guardianDetails.last_name"
            label="Last name"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-text-field
            variant="outlined"
            v-model="guardianDetails.address"
            label="Address"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-radio-group inline>
        <v-radio v-model="guardianDetails.first_name" label="male"></v-radio>
        <v-radio v-model="guardianDetails.first_name" label="female"></v-radio>
      </v-radio-group>
      <v-row>
        <v-col>
          <v-text-field
            variant="outlined"
            v-model="guardianDetails.chatId"
            label="Chat id of guadian"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            variant="outlined"
            v-model="guardianDetails.phone_number"
            label="Phone Number"
          ></v-text-field>
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
import { mapActions, mapState } from 'pinia'
import { useGuardianStore } from '@/stores/guardian'
export default {
  created() {
    const id = this.$route.params.id
    this.getGuardianDetails(id)
  },
  data() {
    return {
      first_name: '',
      last_name: '',
      gender: '',
      chatId: '',
      phone_number: '',
      address: '',
      listGuardian: []
    }
  },
  computed: {
    ...mapState(useGuardianStore, ['guardianDetails'])
  },
  methods: {
    ...mapActions(useGuardianStore, ['getGuardianDetails', 'updateGuardian']),
    addGuadian() {
      // this.updateGuardian(id)
      this.updateGuardian({
        first_name: this.first_name,
        last_name: this.last_name,
        gender: this.gender,
        chatId: this.chatId,
        phone_number: this.phone_number,
        address: this.address
      })
        .then(res => {
          console.log(res);
          // this.$root.$overlay(false)
          // if (!res.data.success) {
          //   throw new Error(res.data.success)
          // }
          // this.$root.$notif(this.$t('success.courrierManagement.updateParam'), {})
          // this.$emit('close')
          // this.dialogParamCourrier = false
        })
        .catch(err => {
          console.log(err);
          // this.$root.$overlay(false)
          // this.$root.$notif(this.$t('error.courrierManagement.updateParam'), {
          //   type: 'error'
          // })
        })
    }
  }
  // methods: {
  //   addGuadian() {
  //     if (
  //       this.first_name &&
  //       this.last_name &&
  //       this.gender &&
  //       this.chatId &&
  //       this.phone_number &&
  //       this.address
  //     ) {
  //       const newGuadian = {
  //         first_name: this.first_name,
  //         last_name: this.last_name,
  //         gender: this.gender,
  //         chatId: this.chatId,
  //         phone_number: this.phone_number,
  //         address: this.address
  //       }
  //       http
  //         .post('/guardians/guardians-create', newGuadian)
  //         .then(response => {
  //           this.listGuadian.push(response.data.data)
  //           console.log(this.listGuadian)
  //         })

  //         .then(() => {
  //           this.$router.push({ path: '/guardian-list' })
  //         })
  //         .catch(error => {
  //           console.log(error)
  //         })
  //     } else {
  //     }
  //   },
  //   editGuardian() {
  //     const newGuadian = {
  //       first_name: this.listGuadian.first_name,
  //       last_name: this.listGuadian.last_name,
  //       gender: this.listGuadian.gender,
  //       chatId: this.listGuadian.chatId,
  //       phone_number: this.listGuadian.phone_number,
  //       address: this.listGuadian.address
  //     }
  //     http.put(`/Guardians/${this.$route.params.id}`, newGuadian).then(response => {
  //       this.$router.push({ path: '/guardian-list' })
  //     })
  //   },
  //   getGuardianById(id) {
  //     if (this.$route.params.id) {
  //       http.get(`/guardians/${this.$route.params.id}/details`).then(response => {
  //         this.listGuadian = response.data.data
  //         console.log(this.listGuadian)
  //       })
  //     }
  //   }
  // },
  // mounted() {
  //   const id = this.$route.params.id
  //   this.getGuardianById(id)
  // }
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

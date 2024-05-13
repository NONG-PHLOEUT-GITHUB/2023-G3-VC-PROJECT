<template>
  <custom-title icon="mdi-human-female-boy"></custom-title>

  <v-card class="pa-2 py-4">
    <form class="row g-3 card-body pt-4" @submit.prevent="addGuadian()">
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
      <v-radio-group inline v-model="guardianDetails.gender">
        <v-radio value="Male" label="Male"></v-radio>
        <v-radio value="Female" label="Female"></v-radio>
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
        <v-btn type="submit" class="mr-2" :to="{ path: '/guardian-list' }" variant="outlined"
          >Cancel
        </v-btn>
        <v-btn type="submit" class="bg-primary">Add Guardian</v-btn>
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
    }
  },
  computed: {
    ...mapState(useGuardianStore, ['guardianDetails'])
  },
  methods: {
    ...mapActions(useGuardianStore, ['getGuardianDetails', 'updateGuardianList']),
    addGuadian() {
      const formData = {
        id: this.$route.params.id,
        first_name: this.guardianDetails.first_name,
        last_name: this.guardianDetails.last_name,
        gender: this.guardianDetails.gender,
        chatId: this.guardianDetails.chatId,
        phone_number: this.guardianDetails.phone_number,
        address: this.guardianDetails.address
      }
      this.updateGuardianList(formData)
        .then(() => {
          this.$root.$notif('Update successfully', {
              type: 'success',
              color: 'primary'
            })
          this.$router.push('/guardian-list')
        })
        .catch(err => {
          console.log(err)
        })
    }
  }
}
</script>

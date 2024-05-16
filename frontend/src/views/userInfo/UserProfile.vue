<template>
  <custom-title icon="mdi-account-details-outline">
    <template #right>
      <v-btn
        class="text-none"
        variant="outlined"
        color="primary"
        append-icon="mdi-pencil"
        @click="isEdit = !isEdit"
        >Edit profile
      </v-btn>
    </template>
  </custom-title>
  <v-form @submit.prevent="updateProfile()">
    <v-layout class="rounded rounded-md px-0">
      <v-col cols="3">
        <v-card>
          <v-card-text class="px-0 text-center">
            <v-col>
              <div>
                <v-avatar
                  v-if="previewImage"
                  color="grey"
                  rounded="100"
                  size="150"
                  class="elevation-1"
                >
                  <v-img :src="previewImage" alt="John"></v-img>
                </v-avatar>
                <v-avatar v-else color="grey" rounded="100" size="150" class="elevation-1">
                  <v-img :src="authUser.profile" cover></v-img>
                </v-avatar>
              </div>
              <v-file-input
                accept="image/png, image/jpeg, image/bmp"
                label="Edit new profile"
                placeholder="Pick an avatar"
                prepend-icon=""
                prepend-inner-icon="mdi-camera"
                variant="outlined"
                counter
                show-size
                chips
                class="mt-3"
                :rules="rules"
                hide-details
                :disabled="isEdit"
                density="compact"
                @change="handleFileChange"
              ></v-file-input>
              <!-- @click:clear="cancel()" -->
            </v-col>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="9" class="pa-1">
        <v-card class="px-2">
          <custom-sub-title icon="mdi-account-card">Personal Information</custom-sub-title>
          <v-row>
            <v-col>
              <v-text-field
                v-model="authUser.first_name"
                density="compact"
                label="First name"
                variant="outlined"
                prepend-inner-icon="mdi-card-account-details-outline"
                readonly
              ></v-text-field>
            </v-col>
            <v-col>
              <v-text-field
                v-model="authUser.last_name"
                density="compact"
                label="Last name"
                variant="outlined"
                readonly
                prepend-inner-icon="mdi-card-account-details-outline"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-text-field
                v-model="authUser.gender"
                density="compact"
                label="Gender"
                variant="outlined"
                readonly
                prepend-inner-icon="mdi-gender-male-female"
              ></v-text-field>
            </v-col>
            <v-col>
              <v-text-field
                v-model="authUser.date_of_birth"
                density="compact"
                label="Date of birth"
                variant="outlined"
                readonly
                prepend-inner-icon=" mdi-calendar-range"
              ></v-text-field>
              <v-text-field
                v-model="authUser.age"
                density="compact"
                label="Age"
                variant="outlined"
                readonly
                prepend-inner-icon="mdi-calendar-multiple-check"
              ></v-text-field>
            </v-col>
          </v-row>
          <custom-sub-title icon="mdi-contacts">Contact Information</custom-sub-title>
          <v-row>
            <v-col>
              <v-text-field
                v-model="authUser.email"
                density="compact"
                label="Email"
                variant="outlined"
                :readonly="isEdit"
                prepend-inner-icon="mdi-email"
              ></v-text-field>
            </v-col>
            <v-col>
              <v-text-field
                v-model="authUser.phone_number"
                density="compact"
                label="Phone number"
                variant="outlined"
                :readonly="isEdit"
                prepend-inner-icon="mdi-phone"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-text-field
                v-model="authUser.address"
                density="compact"
                label="Address"
                variant="outlined"
                :readonly="isEdit"
                prepend-inner-icon="mdi-map-marker"
              ></v-text-field>
            </v-col>
          </v-row>

          <v-card-actions class="px-0">
            <v-spacer></v-spacer>
            <v-btn color="red" variant="outlined" @click="cancel()">Cancel</v-btn>
            <v-btn class="bg-primary" :disabled="isEdit" type="submit">Save change</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-layout>
  </v-form>
</template>

<script>
import { useAuthStore } from '@/stores/auth'
import { useStudentStore } from '@/stores/student'
import { mapActions, mapState } from 'pinia'
export default {
  name: 'UserDetails',
  data() {
    return {
      isEdit: true,
      form: {
        profile_picture: ''
      },
      previewImage: '',
      rules: [
        value => {
          return (
            !value ||
            !value.length ||
            value[0].size < 2000000 ||
            'Avatar size should be less than 2 MB!'
          )
        }
      ]
    }
  },
  created() {
    this.fetchUser()
  },
  computed: {
    ...mapState(useAuthStore, ['authUser'])
  },
  methods: {
    ...mapActions(useAuthStore, ['fetchUser']),
    ...mapActions(useStudentStore, ['updateUser']),
    handleFileChange(event) {
      this.form.profile_picture = event.target.files[0]
      const reader = new FileReader()
      reader.readAsDataURL(this.form.profile_picture)
      reader.onload = e => {
        this.previewImage = e.target.result
      }
    },
    cancel() {
      this.previewImage = null
    },
    updateProfile() {
      const data = {
        id: this.authUser.id,
        email: this.authUser.email,
        phone_number: this.authUser.phone_number,
        address: this.authUser.address,
        profile: this.form.profile_picture
      }
      this.updateUser(data)
        .then(response => {
          console.log(response)
          this.$root.$notif('Update profile successfully', {
            type: 'success',
            color: 'primary'
          })
          this.fetchUser()
        })
        .catch(e => {
          console.log(e)
        })
    }
  }
}
</script>

<template>
  <custom-title icon="mdi-account-details-outline">
    <template #right>
      <v-btn
        class="text-none"
        variant="outlined"
        color="primary"
        append-icon="mdi-pencil"
        @click="isEdit = !isEdit"
      >
        {{ $t('btn.editProfile') }}
      </v-btn>
    </template>
  </custom-title>
  <v-form @submit.prevent="updateProfile()">
    <v-layout class="rounded rounded-md px-0">
      <v-col cols="3" class="pa-1">
        <v-card class="card bg-background">
          <v-card-text class="px-0 text-center">
            <v-col>
              <div>
                <v-avatar
                  v-if="previewImage"
                  color="grey"
                  rounded="100"
                  size="175"
                  class="avatar elevation-1"
                >
                  <v-img :src="previewImage" alt="John"></v-img>
                </v-avatar>
                <v-avatar
                  v-else
                  color="grey"
                  rounded="100"
                  size="175"
                  class="avatar elevation-1"
                >
                  <v-img :src="authUser.profile" cover></v-img>
                </v-avatar>
              </div>
              <v-chip class="mt-2 bg-primary">
                {{ authUser.first_name }} {{ authUser.last_name }}
              </v-chip>
              <v-file-input
                accept="image/png, image/jpeg, image/bmp, image/webp"
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
            </v-col>
          </v-card-text>
        </v-card>
        <v-card class="mt-4 bg-background card">
          <v-list class="pa-0">
            <v-list-subheader>
              <v-list-item-title>Social media</v-list-item-title>
            </v-list-subheader>

            <v-list-item
              v-for="(item, i) in items"
              :key="i"
              :value="item"
              color="primary"
            >
              <template v-slot:append>
                <v-icon :icon="item.icon" color="primary"></v-icon>
              </template>

              <v-list-item-title v-text="item.text"></v-list-item-title>
            </v-list-item>
          </v-list>
        </v-card>
      </v-col>
      <v-col cols="9" class="pa-1">
        <v-card class="card px-2 bg-background">
          <custom-sub-title icon="mdi-account-card">
            {{ $t('profile.pInformation') }}
          </custom-sub-title>
          <v-row>
            <v-col>
              <v-text-field
                v-model="authUser.first_name"
                density="compact"
                label="First name"
                variant="outlined"
                prepend-inner-icon="mdi-card-account-details-outline"
                readonly
                color="textField"
              ></v-text-field>
            </v-col>
            <v-col>
              <v-text-field
                color="textField"
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
                color="textField"
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
                color="textField"
                v-model="authUser.date_of_birth"
                density="compact"
                label="Date of birth"
                variant="outlined"
                readonly
                prepend-inner-icon=" mdi-calendar-range"
              ></v-text-field>
              <v-text-field
                color="textField"
                v-model="authUser.age"
                density="compact"
                label="Age"
                variant="outlined"
                readonly
                prepend-inner-icon="mdi-calendar-multiple-check"
              ></v-text-field>
            </v-col>
          </v-row>
          <custom-sub-title icon="mdi-contacts">
            {{ $t('profile.cInformation') }}
          </custom-sub-title>
          <v-row>
            <v-col>
              <v-text-field
                color="textField"
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
                color="textField"
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
                color="textField"
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
            <v-btn
              color="red"
              variant="outlined"
              :disabled="isEdit"
              @click="goBack()"
              >
              <!-- @click="cancel()" -->
              {{ $t('btn.cancel') }}
            </v-btn>
            <v-btn class="bg-primary" :disabled="isEdit" type="submit">
              {{ $t('btn.saveChange') }}
            </v-btn>
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
        profile_picture: '',
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
        ],
        items: [
          { text: 'Facebook', icon: 'mdi-facebook' },
          { text: 'Twitter', icon: 'mdi-twitter' },
          { text: 'Instagram', icon: 'mdi-instagram' }
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
      ...mapActions(useStudentStore, ['updateUserList']),

      handleFileChange(event) {
        const file = event.target.files[0]
        if (file) {
          this.profile_picture = file
          const reader = new FileReader()
          reader.readAsDataURL(file)
          reader.onload = e => {
            this.previewImage = e.target.result
          }
        } else {
          this.profile_picture = ''
          this.previewImage = ''
        }
      },
      // cancel() {
      //   this.previewImage = null
      //   this.isEdit = false
      // },
      goBack() {
        this.$router.back()
      },
      updateProfile() {
        const data = {
          id: this.authUser.id,
          email: this.authUser.email,
          phone_number: this.authUser.phone_number,
          address: this.authUser.address,
          profile: this.profile_picture
        }

        this.updateUserList(data, data.id)
          .then(() => {
            this.$root.$notif(this.$t('alert.update'), {
              type: 'success',
              color: 'primary'
            })
            this.fetchUser()
            this.profile_picture = ''
          })
          .catch(e => {
            this.$root.$notif('Update profile failed', {
              type: 'error',
              color: 'danger'
            })
          })
      }
    }
  }
</script>
<style scoped>
  .card {
    border-left: solid 3px #89474b;
  }
</style>

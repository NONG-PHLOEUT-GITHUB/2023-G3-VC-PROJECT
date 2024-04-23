<template>
  <custom-title icon="mdi-account-multiple-plus"></custom-title>
  <v-card class="pa-4">
    <v-form @submit.prevent="addUserData()">
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
          <v-radio-group inline>
            <v-radio label="male"></v-radio>
            <v-radio label="female"></v-radio>
          </v-radio-group>
        </v-col>
        <v-col>
          <v-text-field variant="outlined" label="Address"></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-text-field
            variant="outlined"
            :max="max_date"
            v-model="date_of_birth"
            label="Date of birth"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field variant="outlined" label="Email"></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-select
            variant="outlined"
            label="Role"
            :items="roleOption"
            item-title="title"
            item-value="value"
          ></v-select>
        </v-col>
        <v-col>
          <v-text-field variant="outlined" label="Phone Number"></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-file-input
            :rules="rules"
            accept="image/png, image/jpeg, image/bmp"
            label="Avatar"
            placeholder="Pick an avatar"
            prepend-icon="mdi-camera"
            variant="outlined"
            @change="getImage"
          ></v-file-input>
        </v-col>
        <v-col>
          <v-avatar size="62">
            <v-img alt="John" src="https://cdn.vuetifyjs.com/images/john.jpg"></v-img>
          </v-avatar>
        </v-col>
      </v-row>
      <v-row v-show="HideElement">
        <v-col>
          <v-select
            :items="guardians"
            label="Select guardians"
            variant="outlined"
            item-title="guardians"
            item-value="id"
          ></v-select>
        </v-col>
        <v-col>
          <v-select
            :items="classrooms"
            variant="outlined"
            label="Select class"
            item-title="class_name"
            item-value="id"
          ></v-select>
        </v-col>
      </v-row>
      <div class="col-12 d-flex justify-content-end">
        <router-link
          type="submit"
          class="btn btn-warning text-white mr-2"
          :to="{ path: '/student-list' }"
          >Cancel</router-link
        >
        <v-btn type="submit" class="bg-primary">Add User</v-btn>
      </div>
    </v-form>
  </v-card>
</template>

<script>
import axios from 'axios'
import http from '@/api/api'
export default {
  data() {
    return {
      profilePreview: null,
      first_name: '',
      last_name: '',
      email: '',
      phone_number: '',
      address: '',
      date_of_birth: '',
      age: '',
      gender: '',
      profile: '',
      role: '',
      imgURL: 'http://127.0.0.1:8000/api/getImage',
      class_room_id: null,
      guardian_id: null,
      listUser: [],
      classrooms: [],
      guardians: [],
      roleOption: [
        { value: '1', title: 'Administrator' },
        { value: '2', title: 'Teacher' },
        { value: '3', title: 'Student' }
      ],
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
  methods: {
    // resferent :  https://www.youtube.com/watch?v=chCtrNGrQhk
    getImage(event) {
      var file = event.target.files[0]
      console.log(event.target.files[0])
      var form = new FormData()
      form.append('profile', file)
      axios.post(this.imgURL, form).then(response => {
        this.profile = response.data
      })
    },
    addUserData() {
      if (
        this.first_name &&
        this.last_name &&
        this.email &&
        // this.password &&
        this.phone_number &&
        this.address &&
        this.role
      ) {
        const newUser = {
          first_name: this.first_name,
          last_name: this.last_name,
          gender: this.gender,
          role: this.role,
          age: this.age,
          date_of_birth: this.date_of_birth,
          phone_number: this.phone_number,
          address: this.address,
          email: this.email,
          profile: this.profile,
          class_room_id: this.class_room_id,
          guardian_id: this.guardian_id
        }
        http
          .post('/users', newUser)
          .then(response => {
            this.listUser.push(response.data)
          })
          .then(() => {
            this.$router.push({ path: '/student-list' })
          })
          .catch(error => {
            console.error('User update failed:', error)
          })
      } else {
      }
    },
    // get class room for create
    getClassRoom() {
      http.get('/classrooms').then(response => {
        this.classrooms = response.data.data
      })
    },
    // get guardian for create
    getGuardian() {
      http.get('/getGuardians').then(response => {
        this.guardians = response.data.data
      })
    }
  },

  computed: {
    HideElement() {
      return this.role != '1' && this.role != '2'
    },
    max_date() {
      const today = new Date()
      const year = today.getFullYear() - 10
      const month = today.getMonth() + 1 // add 1 because getMonth() returns 0-based month index
      const day = today.getDate()
      return `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`
    },
    calculateAge() {
      if (!this.date_of_birth) return null
      const today = new Date()
      const birthDate = new Date(this.date_of_birth)
      let age = today.getFullYear() - birthDate.getFullYear()
      const monthDiff = today.getMonth() - birthDate.getMonth()
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--
      }
      return age
    }
  },
  mounted() {
    this.getGuardian()
    this.getClassRoom()
  },

  watch: {
    date_of_birth: function () {
      this.age = this.calculateAge
    }
  }
}
</script>

<style scoped>
.gender {
  background: #f8f7f7;
  padding: 10px;
  border-radius: 5px;
  width: 95%;
}

img {
  width: 100px;
}

.container {
  margin-left: 16%;
  width: 85%;
}
</style>

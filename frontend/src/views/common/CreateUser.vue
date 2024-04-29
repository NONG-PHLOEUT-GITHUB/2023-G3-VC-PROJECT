<template>
  <custom-title icon="mdi-account-multiple-plus"></custom-title>
  <v-card class="pa-4">
    <v-form @submit.prevent="addUserData()">
      <v-row>
        <v-col>
          <v-text-field variant="outlined" v-model="first_name" label="First name"></v-text-field>
        </v-col>
        <v-col>
          <v-text-field variant="outlined" v-model="last_name" label="Last name"></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-radio-group inline>
            <v-radio label="male" v-model="gender"></v-radio>
            <v-radio label="female" v-model="gender"></v-radio>
          </v-radio-group>
        </v-col>
        <v-col>
          <v-text-field variant="outlined" v-model="address" label="Address"></v-text-field>
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
          <v-text-field variant="outlined" label="Email" v-model="email"></v-text-field>
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
        <v-col cols="6">
          <v-file-input
            :rules="rules"
            accept="image/png, image/jpeg, image/bmp"
            label="Avatar"
            placeholder="Pick an avatar"
            prepend-icon="mdi-camera"
            variant="outlined"
            counter
            show-size
            chips
            @change="getImage"
          ></v-file-input>
          <!-- <input class="form-control" type="file" id="formFileDisabled" @change="getImage" /> -->
          <!-- @update:modelValue="getImage()" -->
        </v-col>
        <v-col>
          <v-avatar size="62">
            <v-img alt="John" src="https://cdn.vuetifyjs.com/images/john.jpg"></v-img>
          </v-avatar>
        </v-col>
        <v-col>
          <v-switch
            v-model="class_condinator"
            :label="`Class condinator: ${class_condinator}`"
            :false-value="0"
            :true-value="1"
            hide-details
            inset
          ></v-switch>
        </v-col>
      </v-row>
      <v-row v-show="HideElement">
        <v-col>
          <v-text-field
            label="Chat Id of guardians"
            v-model="guardian_id"
            variant="outlined"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-select
            :items="classrooms"
            variant="outlined"
            label="Select class"
            item-title="classroom_name"
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
import { mapActions, mapState } from 'pinia'
import http from '@/api/api'
import { useStudentStore } from '@/stores/student'
export default {
  data() {
    return {
      profilePreview: null,
      first_name: 'Hello',
      last_name: '123',
      email: 'nong245@example.com',
      phone_number: '044009933',
      address: 's2t20.example.com',
      date_of_birth: '2021-12-01',
      age: '12',
      gender: 'male',
      profile: 'http://127.0.0.1:8000/images/2057164142.jpg',
      role: '3',
      class_room_id: '2',
      guardian_id: '2234433',
      class_condinator: '1',
      classrooms: [],
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
  created() {
   const userId = this.$route.params.id
    this.getStudentDetails(userId)
  },
  methods: {
    ...mapActions(useStudentStore, ['createNewStudents','updateUser','getStudentDetails']),
    // resferent :  https://www.youtube.com/watch?v=chCtrNGrQhk
    // var file = event.target.files[0]
    // console.log(event.target.files[0])
    // var form = new FormData()
    // form.append('profile', file)
    // http.post(this.imgURL, form).then(response => {
    //   this.profile = response.data
    // })
    // getImage(e) {
    //   this.profile = e.target.files[0]
    //   console.log(e.target.files[0])
    // },
    getImage(event) {
      let file = event.target.files[0]
      console.log(event.target.files[0])
      var form = new FormData()
      form.append('profile', file)
      http.post(form).then(response => {
        this.profile = response.data
      })
    },
    addUserData() {
      const formData = {
        first_name: this.first_name,
        last_name: this.last_name,
        email: this.email,
        phone_number: this.phone_number,
        address: this.address,
        date_of_birth: this.date_of_birth,
        age: this.age,
        gender: this.gender,
        profile: this.profile,
        role: this.role,
        class_room_id: this.class_room_id,
        is_class_coordinator: this.class_condinator,
        guardian_id: null,
        classrooms: []
      }
      const config = {
        headers: {
          'content-type': 'multipart/form-data'
        }
      }
      // const data = new FormData()
      // data.append('first_name', this.first_name)
      // data.append('last_name', this.last_name)
      // data.append('email', this.email) // Assuming this should be email, not first_name
      // data.append('phone_number', this.phone_number)
      // data.append('address', this.address)
      // data.append('date_of_birth', this.date_of_birth)
      // data.append('age', this.age)
      // data.append('gender', this.gender)
      // data.append('profile', this.profile)
      // data.append('role', this.role)
      // data.append('class_room_id', this.class_room_id)
      // data.append('profile', this.profile)
      // console.log('data', data)
      this.createNewStudents(formData, config).then(response => {
        if (response.status == 201 && response.statusText == 'Created') {
          this.$router.push({ path: '/student-list' })
        }
      })
    },
    // get class room for create
    getClassRoom() {
      http.get('/classrooms').then(response => {
        this.classrooms = response.data.data
      })
    },
    onChange(e) {
      this.file = e.target.files[0]
    },
    formSubmit(e) {
      e.preventDefault()
      let existingObj = this
      const config = {
        headers: {
          'content-type': 'multipart/form-data'
        }
      }
      let data = new FormData()
      data.append('file', this.file)
      axios
        .post('/upload', data, config)
        .then(function (res) {
          existingObj.success = res.data.success
        })
        .catch(function (err) {
          existingObj.output = err
        })
    }
  },

  computed: {
    ...mapState(useStudentStore, ['students']),
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

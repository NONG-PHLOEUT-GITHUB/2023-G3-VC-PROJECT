<template>
  <custom-title icon="mdi-account-multiple-plus"></custom-title>
  <v-card class="pa-4">
    <v-form @submit.prevent="addOrUpdateUser()">
      <v-row>
        <v-col>
          <v-text-field
            variant="outlined"
            v-model="studentDetails.first_name"
            label="First name"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            variant="outlined"
            v-model="studentDetails.last_name"
            label="Last name"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-radio-group v-model="studentDetails.gender" inline>
            <v-radio label="male" value="male"></v-radio>
            <v-radio label="female" value="female"></v-radio>
          </v-radio-group>
        </v-col>
        <v-col>
          <v-text-field
            variant="outlined"
            v-model="studentDetails.address"
            label="Address"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-date-input
            label="Select a date"
            prepend-icon=""
            prepend-inner-icon="$calendar"
            variant="outlined"
            v-model="studentDetails.date_of_birth"
          ></v-date-input>
        </v-col>
        <v-col>
          <v-text-field
            variant="outlined"
            label="Email"
            v-model="studentDetails.email"
          ></v-text-field>
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
            v-model="studentDetails.role"
            chips
            @change="handleRoleChange()"
          ></v-select>
        </v-col>
        <v-col>
          <v-text-field
            variant="outlined"
            v-model="studentDetails.phone_number"
            label="Phone Number"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="6">
          <v-file-input
            :rules="rules"
            accept="image/png, image/jpeg, image/bmp"
            label="Avatar"
            placeholder="Pick an avatar"
            prepend-icon=""
            prepend-inner-icon="mdi-camera"
            variant="outlined"
            counter
            show-size
            chips
            @change="handleFileChange"
          ></v-file-input>
          <!-- :modelValue="studentDetails.profile" -->
        </v-col>
        <v-col>
          <v-avatar size="62">
            <v-img v-if="previewImage" :src="previewImage" alt="John"></v-img>
            <v-img v-else :src="studentDetails.profile"></v-img>
          </v-avatar>
        </v-col>
      </v-row>
      <v-row v-show="showSubject">
        <v-col cols="6">
          <v-select
            :items="subjects"
            variant="outlined"
            label="Assign subject"
            item-title="subject_name"
            item-value="id"
            multiple
            chips
            v-model="studentDetails.subject_id"
          ></v-select>
        </v-col>
      </v-row>

      <v-row v-show="showRow">
        <v-col>
          <v-text-field
            label="Chat Id of guardians"
            v-model="studentDetails.guardian_id"
            variant="outlined"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-select
            :items="classrooms"
            variant="outlined"
            label="Assign student into class"
            item-title="classroom_name"
            item-value="id"
            v-model="studentDetails.classroom_id"
            chips
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
import { useClassroomStore } from '@/stores/classroom'
import { useSubjectStore } from '@/stores/subject'
import { el, fa } from 'vuetify/lib/locale/index.mjs'
export default {
  data() {
    return {
      profile: 'http://127.0.0.1:8000/images/2057164142.jpg',
      roleOption: [
        { value: 1, title: 'Administrator' },
        { value: 2, title: 'Teacher' },
        { value: 3, title: 'Student' }
      ],
      form: {
        profile_picture: ''
      },
      showRow: false,
      showSubject: false,
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
    const userId = this.$route.params.id
    if (userId) {
      this.isUpdate = true
      this.getStudentDetails(userId)
    }
    this.getSubjects()
    this.getCassrooms()
  },
  watch: {
    // Watch for changes in the selected role
    'studentDetails.role': 'handleRoleChange'
  },
  computed: {
    ...mapState(useStudentStore, ['students', 'studentDetails']),
    ...mapState(useClassroomStore, ['classrooms']),
    ...mapState(useSubjectStore, ['subjects'])
  },
  methods: {
    ...mapActions(useStudentStore, ['createNewStudents', 'updateUser', 'getStudentDetails']),
    ...mapActions(useClassroomStore, ['getCassrooms']),
    ...mapActions(useSubjectStore, ['getSubjects']),

    handleFileChange(event) {
      this.form.profile_picture = event.target.files[0]
      const reader = new FileReader()
      reader.readAsDataURL(this.form.profile_picture)
      reader.onload = e => {
        this.previewImage = e.target.result
      }
    },

    handleRoleChange() {
      if (this.studentDetails.role === 1) {
        this.showRow = false
        this.showSubject = false
      } else if (this.studentDetails.role === 2) {
        this.showSubject = true
      } else {
        this.showSubject = false
        this.showRow = true
      }
    },
    getImage(event) {
      let file = event.target.files[0]
      console.log(event.target.files[0])
      var form = new FormData()
      form.append('profile', file)
      http.post(form).then(response => {
        this.profile = response.data
      })
    },
    addOrUpdateUser() {
      const formData = {
        id: parseInt(this.$route.params.id) || '',
        first_name: this.studentDetails.first_name,
        last_name: this.studentDetails.last_name,
        email: this.studentDetails.email,
        phone_number: this.studentDetails.phone_number || '',
        address: this.studentDetails.address || '',
        date_of_birth: "2013-4-5",
        age: this.studentDetails.age || '',
        gender: this.studentDetails.gender || '',
        profile: this.form.profile_picture || '',
        role: this.studentDetails.role || '',
        classroom_id: this.studentDetails.classroom_id || '',
        subject_id: this.studentDetails.subject_id || '',
        guardian_id: this.studentDetails.guardian_id || '',
        classrooms: this.studentDetails.classrooms || ''
      }
      if (!this.isUpdate) {
        this.createNewStudents(formData).then(response => {
          if (response.status == 201 && response.statusText == 'Created') {
            this.$root.$notif('Create successfully', {
              type: 'success',
              color: 'primary'
            })
            if(response){
              console.log(response);
            }
            this.$router.push({ path: '/student-list' })
          }
        })
      } else {
        this.updateUser(formData).then(response => {
          if (response.status == 201 && response.statusText == 'Created') {
            this.$root.$notif('Update successfully', {
              type: 'success',
              color: 'primary'
            })
            this.$router.push({ path: '/student-list' })
          }
        })
      }
    }
  }
}
</script>

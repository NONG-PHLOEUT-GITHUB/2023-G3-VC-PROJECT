<template>
  <custom-title icon="mdi-account-multiple-plus"></custom-title>
  <v-card class="pa-4">
    <custom-sub-title icon="mdi-information">Student Information</custom-sub-title>
    <v-form @submit.prevent="addOrUpdateUser()">
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
            clearable
          ></v-select>
        </v-col>
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
            <v-radio label="Male" value="male"></v-radio>
            <v-radio label="Female" value="female"></v-radio>
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
          <v-text-field
            variant="outlined"
            v-model="studentDetails.phone_number"
            label="Phone Number"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            variant="outlined"
            label="Email"
            v-model="studentDetails.email"
            :error-messages="emailErrorMessage"
            :rules="[rulesEmail.required, rulesEmail.email]"
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
          <!-- <v-text-field
            variant="outlined"
            v-model="studentDetails.date_of_birth"
            label="First name"
            type="date"
          ></v-text-field> -->
        </v-col>
        <v-col>
          <v-text-field
            variant="outlined"
            label="Age"
            v-model="studentDetails.email"
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
        <v-col cols="6">
          <v-select
            :items="classrooms"
            variant="outlined"
            label="Assign student into class"
            item-title="classroom_name"
            item-value="id"
            v-model="studentDetails.classroom_id"
            chips
            clearable
          ></v-select>
        </v-col>
      </v-row>
      <v-card-text v-show="showRow" class="pa-0">
        <custom-sub-title icon="mdi-information">Parent Information</custom-sub-title>
        <v-row>
          <v-col>
            <v-text-field
              variant="outlined"
              v-model="parents.first_name"
              label="First name"
            ></v-text-field>
          </v-col>
          <v-col>
            <v-text-field
              variant="outlined"
              v-model="parents.last_name"
              label="Last name"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-radio-group inline v-model="parents.gender">
              <v-radio label="Male"></v-radio>
              <v-radio label="Female"></v-radio>
            </v-radio-group>
          </v-col>
          <v-col>
            <v-text-field
              variant="outlined"
              v-model="parents.address"
              label="Address"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-text-field
              variant="outlined"
              v-model="parents.chatId"
              label="Chat id of guadian"
            ></v-text-field>
          </v-col>
          <v-col>
            <v-text-field
              variant="outlined"
              v-model="parents.phone_number"
              label="Phone Number"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-card-text>
      <div class="col-12 d-flex justify-content-end">
        <v-btn type="submit" class="mr-2" :to="{ path: '/student-list' }" variant="outlined"
          >Cancel
        </v-btn>
        <v-btn v-if="!btn" type="submit" class="bg-primary">Create</v-btn>
        <v-btn v-else type="submit" class="bg-primary">Update</v-btn>
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
import { format } from 'date-fns'

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
      ],
      rulesEmail: {
        required: value => !!value || 'Required.',
        counter: value => value.length <= 20 || 'Max 20 characters',
        email: value => {
          const pattern =
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
          return pattern.test(value) || 'Invalid e-mail.'
        }
      },
      email: '',
      emailErrorMessage: '',
      parents: {
        first_name: '',
        last_name: '',
        email: '',
        phone_number: '',
        address: '',
        chatId: ''
      },
      btn:false,
    }
  },
  created() {
    const userId = this.$route.params.id
    if (userId) {
      this.isUpdate = true
      this.getStudentDetails(userId),
      this.btn = true
    }
    this.getSubjects()
    this.getCassrooms()
    this.handleRoleChange()
  },
  watch: {
    // Watch for changes in the selected role
    'studentDetails.role': 'handleRoleChange'
  },
  computed: {
    ...mapState(useStudentStore, ['students', 'studentDetails']),
    ...mapState(useClassroomStore, ['classrooms']),
    ...mapState(useSubjectStore, ['subjects']),
    formattedDate() {
      // Use the format function to format the date
      return format(this.studentDetails.date_of_birth, 'yyyy-MM-dd');
    },
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
      const role = this.studentDetails.role
      this.showRow = role === 3
      this.showSubject = role === 2
      //If the role is 3, this.showRow is set to true,
      //If the role is 2, this.showSubject is set to true
    },

    addOrUpdateUser() {
      const formData = {
        first_name: this.studentDetails.first_name,
        last_name: this.studentDetails.last_name,
        email: this.studentDetails.email,
        phone_number: this.studentDetails.phone_number || '',
        address: this.studentDetails.address || '',
        date_of_birth: this.formattedDate || "",
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
        this.createNewStudents(formData)
          .then(response => {
            if (response.status == 201 && response.statusText == 'Created') {
              this.$root.$notif('Create successfully', {
                type: 'success',
                color: 'primary'
              })
              if (response) {
                console.log(response)
              }
              this.$router.push({ path: '/student-list' })
            }
          })
          .catch(error => {
            if (error.response.status === 422) {
              this.emailErrorMessage = 'Email already exists.'
            }
          })
      } else {
        const id = parseInt(this.$route.params.id)
        this.updateUser(formData,id).then(response => {
          if (response.status == 201 && response.statusText == 'Created') {
            this.$root.$notif('Update successfully', {
              type: 'success',
              color: 'primary'
            })
            const role = response.data.data.role
            if (role == 1 || role == 2) {
              this.$router.push({ path: '/teacher-list' })
            }else {
              this.$router.push({ path: '/student-list' })
            }
          }
        })
      }
    }
  }
}
</script>

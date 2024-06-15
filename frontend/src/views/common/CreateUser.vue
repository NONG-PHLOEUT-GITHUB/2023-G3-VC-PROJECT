<template>
  <custom-title icon="mdi-account-multiple-plus"></custom-title>
  <v-card class="pa-4">
    <custom-sub-title icon="mdi-information">
      Student Information
    </custom-sub-title>
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
            :rules="[() => !!studentDetails.role || 'This field is required']"
          ></v-select>
        </v-col>
        <v-col>
          <v-text-field
            variant="outlined"
            v-model="studentDetails.first_name"
            label="First name"
            :rules="[
              () => !!studentDetails.first_name || 'This field is required'
            ]"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            variant="outlined"
            v-model="studentDetails.last_name"
            label="Last name"
            :rules="[
              () => !!studentDetails.last_name || 'This field is required'
            ]"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-radio-group
            :rules="[() => !!studentDetails.gender || 'This field is required']"
            v-model="studentDetails.gender"
            inline
          >
            <v-radio label="Male" value="Male"></v-radio>
            <v-radio label="Female" value="Female"></v-radio>
          </v-radio-group>
        </v-col>
        <v-col>
          <v-text-field
            variant="outlined"
            v-model="studentDetails.address"
            label="Address"
            :rules="[
              () => !!studentDetails.address || 'This field is required'
            ]"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-text-field
            variant="outlined"
            v-model="studentDetails.phone_number"
            label="Phone Number"
            :rules="[
              () => !!studentDetails.phone_number || 'This field is required'
            ]"
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
          <v-text-field
            label="Date of Birth"
            variant="outlined"
            v-model="studentDetails.date_of_birth"
            type="date"
            :rules="[
              () => !!studentDetails.date_of_birth || 'This field is required',
              value => {
                if (!value) return true
                const selectedDate = new Date(value)
                const today = new Date()
                return (
                  selectedDate <= today ||
                  'Date of Birth cannot be in the future'
                )
              }
            ]"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            variant="outlined"
            :rules="[() => !!studentDetails.age || 'This field is required']"
            label="Age"
            v-model="studentDetails.age"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="6">
          <v-file-input
            ref="profile"
            :rules="profileRules"
            accept="image/png, image/jpeg, image/bmp"
            label="Apload user profile"
            placeholder="Pick an avatar"
            prepend-icon=""
            prepend-inner-icon="mdi-camera"
            variant="outlined"
            counter
            show-size
            chips
            @change="handleFileChange"
          ></v-file-input>
        </v-col>
        <!-- v-model="studentDetails.profile" -->
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
            clearable
            v-model="subjectSelected"
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
        <custom-sub-title icon="mdi-information">
          Parent Information
        </custom-sub-title>
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
              <v-radio label="Male" value="Male"></v-radio>
              <v-radio label="Female" value="Female"></v-radio>
            </v-radio-group>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-text-field
              variant="outlined"
              v-model="parents.address"
              label="Address"
            ></v-text-field>
          </v-col>
          <v-col>
            <v-text-field
              label="Date of birth"
              variant="outlined"
              v-model="parents.date_of_birth"
              type="date"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-text-field
              variant="outlined"
              v-model="parents.chat_id"
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
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          v-if="studentDetails.role == 3"
          type="submit"
          class="mr-2"
          :to="{ path: '/student-list' }"
          variant="outlined"
        >
          {{ $t('btn.cancel') }}
        </v-btn>
        <v-btn
          v-else
          type="submit"
          class="mr-2"
          :to="{ path: '/teacher-list' }"
          variant="outlined"
        >
          {{ $t('btn.cancel') }}
        </v-btn>
        <v-btn v-if="!btn" type="submit" class="bg-primary">
          {{ $t('btn.create') }}
        </v-btn>
        <v-btn v-else type="submit" class="bg-primary">
          {{ $t('btn.update') }}
        </v-btn>
      </v-card-actions>
    </v-form>
  </v-card>
</template>

<script>
  import { mapActions, mapState } from 'pinia'
  import { useStudentStore } from '@/stores/student'
  import { useClassroomStore } from '@/stores/classroom'
  import { useSubjectStore } from '@/stores/subject'
  import { useGuardianStore } from '@/stores/guardian'
  export default {
    data() {
      return {
        btn: false,
        emailErrorMessage: '',
        profile_picture: '',
        previewImage: '',
        showRow: false,
        showSubject: false,
        subjectSelected: [],
        roleOption: [
          { value: 1, title: 'Administrator' },
          { value: 2, title: 'Teacher' },
          { value: 3, title: 'Student' }
        ],
        profileRules: [
          value => {
            if (!value || value.length === 0) {
              return 'Avatar is required!'
            }
            return true
          },
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
          required: value => !!value || 'Email is required.',
          counter: value => value.length <= 20 || 'Max 20 characters',
          email: value => {
            const pattern =
              /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            return pattern.test(value) || 'Invalid e-mail.'
          }
        },
        parents: {
          first_name: '',
          last_name: '',
          phone_number: '',
          address: '',
          chat_id: '',
          gender: '',
          date_of_birth: ''
        }
      }
    },
    created() {
      const userId = this.$route.params.id
      if (userId) {
        this.isUpdate = true
        this.getStudentDetails(userId), (this.btn = true)
      }
      this.getSubjects()
      this.getCassrooms()
      this.handleRoleChange()
    },
    watch: {
      // Watch for changes in the selected role
      'studentDetails.role': 'handleRoleChange',
      'studentDetails.date_of_birth': function (newDate) {
        this.studentDetails.age = this.calculateAge(newDate)
      }
    },
    computed: {
      ...mapState(useStudentStore, ['students', 'studentDetails']),
      ...mapState(useClassroomStore, ['classrooms']),
      ...mapState(useSubjectStore, ['subjects']),
      // subjectSelected() {
      //   return this.studentDetails.subjects // Or however you want to compute subjectSelected
      // }
    },
    methods: {
      ...mapActions(useStudentStore, [
        'createNewStudents',
        'updateUserList',
        'getStudentDetails'
      ]),
      ...mapActions(useClassroomStore, ['getCassrooms']),
      ...mapActions(useSubjectStore, ['getSubjects']),
      ...mapActions(useGuardianStore, ['createNewGuardian']),

      calculateAge(dateOfBirth) {
        if (!dateOfBirth) return ''
        const birthDate = new Date(dateOfBirth)
        const today = new Date()
        let age = today.getFullYear() - birthDate.getFullYear()
        const monthDifference = today.getMonth() - birthDate.getMonth()
        if (
          monthDifference < 0 ||
          (monthDifference === 0 && today.getDate() < birthDate.getDate())
        ) {
          age--
        }
        return age
      },
      handleFileChange(event) {
        this.profile_picture = event.target.files[0]
        const reader = new FileReader()
        reader.readAsDataURL(this.profile_picture)
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
          date_of_birth: this.date_of_birth || '',
          age: this.studentDetails.age || '',
          gender: this.studentDetails.gender || '',
          profile: this.profile_picture || '',
          role: this.studentDetails.role || '',
          classroom_id: this.studentDetails.classroom_id || '',
          subject_id: this.studentDetails.subjectSelected || null,
          guardian_id: this.studentDetails.guardian_id || ''
        }

        if (!this.isUpdate) {
          this.createNewStudents(formData)
            .then(response => {
              if (response.status == 201) {
                if (
                  this.studentDetails.role == 2 ||
                  this.studentDetails.role == 1
                ) {
                  this.$root.$notif(this.$t('alert.create'), {
                    type: 'success',
                    color: 'primary'
                  })
                  this.$router.push({ path: '/teacher-list' })
                } else {
                  // call to create the parent
                  this.createParents()
                  this.$root.$notif(this.$t('alert.create'), {
                    type: 'success',
                    color: 'primary'
                  })
                  this.$router.push({ path: '/student-list' })
                }
              }
            })
            .catch(error => {
              if (error.response.status === 422) {
                this.emailErrorMessage = 'Email already exists.'
              }
            })
        } else {
          const id = parseInt(this.$route.params.id)
          this.updateUserList(formData, id)
            .then(response => {
              if (response.status == 201 && response.statusText == 'Created') {
                this.$root.$notif('Update successfully', {
                  type: 'success',
                  color: 'primary'
                })
                const role = response.data.data.role
                const redirectPath =
                  role === 1 || role === 2 ? '/teacher-list' : '/student-list'
                this.$router.push({ path: redirectPath })
              }
            })
            .catch(e => {
              console.log(e)
            })
        }
      },
      createParents() {
        ///create new parent
        const parentsData = {
          first_name: this.parents.first_name,
          last_name: this.parents.last_name,
          phone_number: this.parents.phone_number,
          address: this.parents.address,
          chat_id: this.parents.chat_id,
          gender: this.parents.gender,
          date_of_birth: this.parents.date_of_birth
        }
        this.createNewGuardian(parentsData)
          .then(response => {
            console.log(response)
          })
          .catch(error => {
            console.log(error)
          })
      }
    }
  }
</script>

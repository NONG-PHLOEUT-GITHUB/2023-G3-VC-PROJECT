<template>
  <custom-title icon="mdi-account-multiple-plus"></custom-title>
  <v-card class="pa-4">
    <custom-sub-title icon="mdi-information">
      Student Information
    </custom-sub-title>
    <v-form>
      <v-row>
        <v-col>
          <v-select
            variant="outlined"
            label="Role"
            :items="roleOption"
            item-title="title"
            item-value="value"
            v-model="studentShow.role"
            chips
            @change="handleRoleChange()"
            clearable
            :rules="[() => !!studentShow.role || 'This field is required']"
          ></v-select>
        </v-col>
        <v-col>
          <v-text-field
            color="textField"
            variant="outlined"
            v-model="studentShow.first_name"
            label="First name"
            :rules="[
              () => !!studentShow.first_name || 'This field is required'
            ]"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            color="textField"
            variant="outlined"
            v-model="studentShow.last_name"
            label="Last name"
            :rules="[() => !!studentShow.last_name || 'This field is required']"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-radio-group
            :rules="[() => !!studentShow.gender || 'This field is required']"
            v-model="studentShow.gender"
            inline
          >
            <v-radio label="Male" value="Male"></v-radio>
            <v-radio label="Female" value="Female"></v-radio>
          </v-radio-group>
        </v-col>
        <v-col>
          <v-text-field
            color="textField"
            variant="outlined"
            v-model="studentShow.address"
            label="Address"
            :rules="[() => !!studentShow.address || 'This field is required']"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-text-field
            color="textField"
            variant="outlined"
            v-model="studentShow.phone_number"
            label="Phone Number"
            :rules="[
              () => !!studentShow.phone_number || 'This field is required'
            ]"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            color="textField"
            variant="outlined"
            label="Email"
            v-model="studentShow.email"
            :error-messages="emailErrorMessage"
            :rules="[rulesEmail.required, rulesEmail.email]"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-text-field
            color="textField"
            label="Date of Birth"
            variant="outlined"
            v-model="studentShow.date_of_birth"
            type="date"
            :rules="[
              () => !!studentShow.date_of_birth || 'This field is required',
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
            color="textField"
            variant="outlined"
            :rules="[() => !!studentShow.age || 'This field is required']"
            label="Age"
            v-model="studentShow.age"
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
        <v-col>
          <v-avatar size="62">
            <v-img v-if="previewImage" :src="previewImage" alt="John"></v-img>
            <v-img v-else :src="studentShow.profile"></v-img>
          </v-avatar>
        </v-col>
      </v-row>
      <v-row v-if="studentShow.role === 2">
        <v-col cols="6">
          <v-select
            v-model="studentShow.subjects"
            :items="subjects"
            variant="outlined"
            label="Assign subject"
            item-title="subject_name"
            item-value="id"
            multiple
            chips
            clearable
          ></v-select>
        </v-col>
      </v-row>
      <v-row v-if="studentShow.role === 3">
        <v-col cols="6">
          <v-select
            :items="classrooms"
            variant="outlined"
            label="Assign student into class"
            item-title="classroom_name"
            item-value="id"
            v-model="studentShow.classroom_id"
            chips
            clearable
          ></v-select>
        </v-col>
      </v-row>

      <form-guardian
        v-if="studentShow.role === 3"
        ref="formGuardian"
        :guardian-details="guardianDetails"
        @submit="handleGuardianSubmit"
      />
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          type="button"
          class="mr-2"
          :to="studentShow.role === 3 ? '/student-list' : '/teacher-list'"
          variant="outlined"
        >
          {{ $t('btn.cancel') }}
        </v-btn>
        <v-btn type="submit" class="bg-primary" @click="addOrUpdateUser">
          {{ btn ? $t('btn.update') : $t('btn.create') }}
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
  import FormGuardian from '@/components/common/FormGuardian.vue'
  export default {
    components: { FormGuardian },
    data() {
      return {
        btn: false,
        emailErrorMessage: '',
        profile_picture: '',
        previewImage: '',
        subjectSelect: [],
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
        }
      }
    },
    created() {
      const userId = this.$route.params.id
      if (userId) {
        this.isUpdate = true
        this.showStudent(userId), (this.btn = true)
      }
      this.getSubjects()
      this.getCassrooms()
      this.handleRoleChange()
    },
    watch: {
      'studentShow.date_of_birth': function (newDate) {
        this.studentShow.age = this.calculateAge(newDate)
      },
      'studentShow.parent_id': function (newParentId) {
        if (!newParentId) {
          this.guardianDetails = {}
        } else {
          this.getGuardianDetails(newParentId)
        }
      }
    },
    computed: {
      ...mapState(useStudentStore, ['students', 'studentShow']),
      ...mapState(useClassroomStore, ['classrooms']),
      ...mapState(useSubjectStore, ['subjects']),
      ...mapState(useGuardianStore, ['guardianDetails'])
    },
    methods: {
      ...mapActions(useStudentStore, [
        'createNewStudents',
        'updateUserList',
        'showStudent'
      ]),
      ...mapActions(useClassroomStore, ['getCassrooms']),
      ...mapActions(useSubjectStore, ['getSubjects']),
      ...mapActions(useGuardianStore, [
        'createNewGuardian',
        'getGuardianDetails',
        'updateGuardianList'
      ]),
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
        const role = this.studentShow.role
        this.showRow = role === 3
        this.showSubject = role === 2
      },

      async addOrUpdateUser() {
        const formData = {
          ...this.studentShow, // get access to object data
          // guardian_id:this.guardian_id,
          profile: this.profile_picture || ''
        }
        try {
          if (this.isUpdate) {
            const id = parseInt(this.$route.params.id)
            await this.updateUserList(formData, id)
            this.$root.$notif('Update successfully', {
              type: 'success',
              color: 'primary'
            })
          } else {
            if (this.studentShow.role === 3) {
              this.$refs.formGuardian.emitSubmit()
              this.$router.push('/student-list')
            }
            else {
              this.$router.push('/teacher-list')
            }
            await this.createNewStudents(formData)
            this.$root.$notif(this.$t('alert.create'), {
              type: 'success',
              color: 'primary'
            })
          }
          this.formData = ''
        } catch (error) {
          if (error.response.status === 422) {
            this.emailErrorMessage = 'Email already exists.'
          }
        }
      },
      async handleGuardianSubmit(formData) {
        try {
          await this.createNewGuardian(formData)
          // await this.updateGuardianList(formData)
        } catch (error) {
          console.log(error)
        }
      },
    }
  }
</script>

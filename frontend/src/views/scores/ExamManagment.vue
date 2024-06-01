<template>
  <custom-title icon="mdi-scoreboard-outline">
    <template #right>
      <v-btn
        icon="mdi-filter-multiple-outline"
        variant="tonal"
        class="me-2 bg-primary"
        @click="toggleFilter = !toggleFilter"
      ></v-btn>
      <v-btn
        variant="tonal"
        class="bg-primary"
        @click="dialog = !dialog"
        icon="mdi-database-plus"
      ></v-btn>
    </template>
  </custom-title>

  <v-dialog v-model="dialog" persistent width="40%">
    <v-card>
      <v-form @submit.prevent="addNewExam">
        <v-card-title class="bg-primary">
          <span class="text-h5">{{ formAction }}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="examName"
                  label="Exam name"
                  required
                  variant="outlined"
                ></v-text-field>
                <!-- :error-messages="classNameRole" -->
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="Exam code"
                  variant="outlined"
                  clearable
                  v-model="examCode"
                  chips
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-select
                  label="subject examination"
                  variant="outlined"
                  :items="subjects"
                  item-title="subject_name"
                  item-value="id"
                  clearable
                  chips
                  v-model="selectedSubject"
                >
                </v-select>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue-darken-1" variant="outlined" @click="dialog = false">{{ $t('btn.cancel') }}</v-btn>
          <v-btn type="submit" class="bg-blue-darken-1">{{$t('btn.save')}}</v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>

  <v-data-table
    :headers="headers"
    :items="exams"
    item-title="exam_name"
    item-value="id"
    class="elevation-1"
  >
    <template v-slot:item.actions="{ item }">
      <v-btn @click="deleteExamList(item.id)" variant="text" icon="mdi-delete-forever" color="red">
      </v-btn>
      <v-tooltip text="Upload score of exam">
        <template v-slot:activator="{ props }">
          <v-btn
            color="primary"
            v-bind="props"
            variant="text"
            icon="mdi-database-import-outline"
            @click="dialogImport = !dialogImport"
          ></v-btn>
        </template>
      </v-tooltip>
    </template>
  </v-data-table>

  <v-dialog v-model="dialogImport"  max-width="500">
    <v-form @submit.prevent="importScoresExcelFile">
      <v-card rounded="lg">
        <v-card-title class="d-flex justify-space-between align-center">
          <div class="text-h5 text-medium-emphasis ps-2">Scores upload</div>

          <v-btn icon="mdi-close" variant="text" @click="dialogImport = false"></v-btn>
        </v-card-title>

        <v-divider class="mb-4"></v-divider>

        <v-card-text>
          <div class="text-medium-emphasis mb-4">
            Invite collaborators to your network and grow your connections.
          </div>
          <v-file-input
            label="Upload score "
            placeholder="Pick an avatar"
            prepend-icon=""
            prepend-inner-icon="mdi-file"
            variant="outlined"
            counter
            show-size
            chips
            type="file" 
            ref="fileInput"
            ></v-file-input>
            <!-- @change="importScoresExcelFile" -->
        </v-card-text>

        <v-divider class="mt-2"></v-divider>

        <v-card-actions class="my-2 d-flex justify-end">
          <v-btn
            class="text-none"
            rounded="xl"
            text="Cancel"
            @click="dialogImport= false"
          ></v-btn>

          <v-btn
            class="text-none"
            color="primary"
            rounded="xl"
            text="Send"
            variant="flat"
            type="submit"
            ></v-btn>
            <!-- @click="dialogImport= false" -->
        </v-card-actions>
      </v-card>
    </v-form>
  </v-dialog>
</template>

<script>
import { mapActions, mapState } from 'pinia'
import { useExamStore } from '@/stores/exam'
import { useSubjectStore } from '@/stores/subject'
import { useAuthStore } from '@/stores/auth'
import http from '@/api/api'
export default {
  data: () => ({
    dialog: false,
    dialogImport: false,
    formAction: 'Create new exampination',
    selectedSubject: null,
    examCode: '',
    examName: '',
    headers: [
      { title: 'Exam name', key: 'exam_name' },
      { title: 'Exam code', key: 'exam_code' },
      { title: 'Subject name', key: 'subject_name' },
      { title: '', key: 'actions' }
    ]
  }),
  created() {
    this.getSubjects()
    this.getExams()
    this.fetchUser()
  },
  computed: {
    ...mapState(useSubjectStore, ['subjects']),
    ...mapState(useExamStore, ['exams']),
    teacherId(){
      return useAuthStore().getUserId
    }
  },
  methods: {
    ...mapActions(useExamStore, ['createExam', 'getExams', 'deleteExam']),
    ...mapActions(useSubjectStore, ['getSubjects']),
    ...mapActions(useAuthStore, ['fetchUser']),
    addNewExam() {
      const fromData = {
        subject_id: this.selectedSubject,
        exam_code: this.examCode,
        exam_name: this.examName,
        create_by: this.teacherId
      }
      this.formAction = 'Create new exampination'
      this.createExam(fromData).then(response => {
        if (response) {
          this.dialog = false
          this.$root.$notif('Create successfully', {
            type: 'success',
            color: 'primary'
          })
          this.getExams()
        }
      })
    },
    deleteExamList(id) {
      this.deleteExam(id).then(response => {
        if (response) {
          this.$root.$notif('Delete successfully', {
            type: 'success',
            color: 'primary'
          })
          this.getExams()
        }
      })
    },
    importScoresExcelFile() {
      const file = this.$refs.fileInput.files[0]
      const formData = new FormData()
      formData.append('file', file)
      http
        .post('/scores/import-score', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
            'Cache-Control': 'no-cache'
          }
        })
        .then(response => {
          console.log(response.data)
          // Reset the file input field
          this.$refs.fileInput.value = ''
          // call mounted
          this.$root.$notif('Upload successfully', {
            type: 'success',
            color: 'primary'
          })
          this.dialogImport = false
        })
        .catch(error => {
          console.error(error)
        })
    }
  }
}
</script>

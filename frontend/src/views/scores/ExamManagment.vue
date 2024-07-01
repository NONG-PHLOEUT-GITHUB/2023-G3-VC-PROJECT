<template>
  <custom-title icon="mdi-scoreboard-outline">
    <template #right>
      <v-btn
        variant="outlined"
        append-icon="mdi-filter-multiple-outline"
        class="text-none me-4"
        color="primary"
        @click="toggleFilter = !toggleFilter"
      >
        {{ $t('btn.filter') }}
      </v-btn>
      <v-btn
        append-icon="mdi-plus"
        class="text-none"
        color="primary"
        @click="dialog = !dialog"
      >
        {{ $t('btn.create') }}
      </v-btn>
    </template>
  </custom-title>

  <v-slide-y-reverse-transition mode="in-out">
    <filter-exam v-show="toggleFilter" @filter-exam="onFilterApplied" />
  </v-slide-y-reverse-transition>
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
                  color="textField"
                  v-model="examName"
                  label="Exam name"
                  required
                  variant="outlined"
                ></v-text-field>
                <!-- :error-messages="classNameRole" -->
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="textField"
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
                  color="textField"
                ></v-select>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" variant="outlined" @click="dialog = false">
            {{ $t('btn.cancel') }}
          </v-btn>
          <v-btn type="submit" class="bg-primary">
            {{ $t('btn.save') }}
          </v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>

  <v-data-table
    :headers="headers"
    :items="exams"
    item-title="exam_name"
    item-value="id"
    class="elevation-0"
  >
    <template v-slot:item.actions="{ item }">
      <v-btn
        @click="update(item.id)"
        variant="text"
        icon="mdi-pencil"
        color="error"
      ></v-btn>
      <v-tooltip text="Upload score of exam">
        <template v-slot:activator="{ props }">
          <v-btn
            color="green"
            v-bind="props"
            variant="text"
            icon="mdi-database-import-outline"
            @click="dialogImport = !dialogImport"
          ></v-btn>
        </template>
      </v-tooltip>
      <v-btn
        @click="deleteExamList(item.id)"
        variant="text"
        icon="mdi-delete-forever"
        color="error"
      ></v-btn>
    </template>
  </v-data-table>

  <v-dialog v-model="dialogImport" max-width="500">
    <v-form @submit.prevent="importScoresExcelFile">
      <v-card rounded="lg">
        <v-card-title class="d-flex justify-space-between align-center">
          <div class="text-h5 text-medium-emphasis ps-2">Scores upload</div>

          <v-btn
            icon="mdi-close"
            variant="text"
            @click="dialogImport = false"
          ></v-btn>
        </v-card-title>

        <v-divider class="mb-4"></v-divider>

        <v-card-text>
          <div class="text-medium-emphasis mb-4">
            Please upload scores following the name of the exam.
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
            :text="$t('btn.cancel')"
            @click="dialogImport = false"
          ></v-btn>

          <v-btn class="text-none" color="primary" variant="flat" type="submit">
            {{ $t('btn.save') }}
          </v-btn>
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
  import FilterExam from '@/components/filters/FilterExam.vue'
  import http from '@/api/api'
  export default {
    components: { FilterExam },
    data: () => ({
      dialog: false,
      dialogImport: false,
      toggleFilter: false,
      formAction: 'Create new exampination',
      selectedSubject: null,
      examCode: '',
      examName: '',
      filterCriteria: {},
      headers: [
        { title: '#ID', key: 'id' },
        { title: 'Exam name', key: 'exam_name' },
        { title: 'Exam code', key: 'exam_code' },
        { title: 'Subject name', key: 'subject_name' },
        { title: '', key: 'actions' }
      ]
    }),
    created() {
      this.getSubjects()
      this.getExams(this.filterCriteria)
      this.fetchUser()
    },
    computed: {
      ...mapState(useSubjectStore, ['subjects']),
      ...mapState(useExamStore, ['exams']),
      teacherId() {
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
            this.$root.$notif(this.$t('alert.create'), {
              type: 'success',
              color: 'primary'
            })
            this.getExams()
          }
        })
      },
      deleteExamList(id) {
        this.$root.$confirm({
          title: 'Are you sure?',
          message: 'Are you sure you want to delete this exam?',
          options: {
            agreeBtnText: 'Yes',
            type: 'error',
            color: 'error',
            width: 400
          },
          agree: () =>
            this.deleteExam(id).then(response => {
              if (response) {
                this.$root.$notif(this.$t('alert.delete'), {
                  type: 'success',
                  color: 'primary'
                })
                this.getExams(this.filterCriteria)
              }
            })
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
          .then(() => {
            this.$refs.fileInput.value = ''
            this.$root.$notif('Upload successfully', {
              type: 'success',
              color: 'primary'
            })
            this.dialogImport = false
          })
          .catch(error => {
            console.error(error)
          })
      },
      onFilterApplied(filterText) {
        this.filterCriteria = filterText
        this.getExams(this.filterCriteria)
      }
    }
  }
</script>

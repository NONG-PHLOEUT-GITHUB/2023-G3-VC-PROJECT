<template>
  <custom-title icon="mdi-chair-school">
    <template #right>
      <v-btn
        icon="mdi-filter-multiple-outline"
        variant="tonal"
        class="me-2 bg-primary"
        @click="toggleFilter = !toggleFilter"
      ></v-btn>
      <v-btn
        variant="tonal"
        class="me-2 bg-deep-orange-accent-4"
        icon="mdi-file-pdf-box"
        @click="downloadPDF()"
      ></v-btn>
      <v-btn variant="tonal" class="me-2 bg-green-darken-1" icon="mdi-file-excel"></v-btn>
      <v-btn color="teal-darken-4" @click="dialog = true"
        ><v-icon>mdi-plus-outline</v-icon>Add</v-btn
      >
    </template>
  </custom-title>

  <v-dialog v-model="dialog" persistent width="40%">
    <v-card>
      <v-form @submit.prevent="saveClassroom">
        <v-card-title class="bg-primary">
          <span class="text-h5">{{ formAction }}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="className"
                  label="Class name"
                  required
                  variant="outlined"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-select
                  label="Teacher assignee"
                  variant="outlined"
                  :items="teacherList"
                  :item-title="fullName"
                  item-value="id"
                  clearable
                  v-model="selectedTeacherId"
                  @update:model-value="selectCordinator()"
                ></v-select>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue-darken-1" variant="text" @click="dialog = false">Cancel</v-btn>
          <v-btn type="submit" color="blue-darken-1">Save</v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>

  <v-row dense>
    <v-col cols="12" md="3" v-for="classroom in classrooms">
      <v-card
        prepend-icon="mdi-chair-school"
        :title="classroom.classroom_name"
        :subtitle="classroom.student_count"
      >
        <template v-slot:append>
          <v-menu>
            <template v-slot:activator="{ props }">
              <v-btn icon="mdi-dots-vertical" class="elevation-0" v-bind="props"></v-btn>
            </template>

            <v-list density="compact">
              <v-list-item
                v-for="(item, i) in items"
                :key="i"
                :value="item"
                @click="onMenuClick(item.action, classroom.id)"
              >
                <template v-slot:prepend>
                  <v-icon :icon="item.icon" :color="item.color"></v-icon>
                </template>
                <v-list-item-title v-text="item.title"></v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </template>
        <!-- <v-card-text>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</v-card-text> -->
        <v-card-actions>
          <!-- <v-btn
          color="teal-darken-4"
          :to="{ path: '/student-score-report/' + classroom.id }"
          class="me-4"
        >
          <v-icon>mdi-chart-line</v-icon> Score report
        </v-btn> -->
          <v-btn color="teal-darken-4" :to="'/student/' + classroom.id + '/feedback'" class="me-1">
            Studen List
          </v-btn>
          <v-btn
            color="orange"
            :to="`/attendance/` + classroom.id + `/student`"
            text="Check attendance"
          ></v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import http from '@/api/api'
import { useClassroomStore } from '@/stores/classroom'
import { mapActions, mapState } from 'pinia'
export default {
  data() {
    return {
      selectedClass: '',
      dialog: false,
      teachers: [],
      selectedTeacher: null,
      teacherList: [],
      className: '',
      formAction: 'Create new classroom',
      editing: false,
      editId: null,
      listClass: [],
      selectedTeacherId: null,
      items: [
        { action: 'edit', title: 'Edite', icon: 'mdi-delete', color: 'red' },
        { action: 'delete', title: 'Delete', icon: 'mdi-pencil' }
      ]
    }
  },
  created() {
    this.getCassrooms()
  },
  computed: {
    ...mapState(useClassroomStore, ['classrooms']),
    fullName() {
      return function (item) {
        return item.first_name + ' ' + item.last_name
      }
    }
  },

  methods: {
    ...mapActions(useClassroomStore, ['getCassrooms', 'deleteCassroom']),
    onMenuClick(action, id) {
      switch (action) {
        case 'edit':
          this.deleteClassroom(id)
          break
        case 'delete':
          this.deleteClassroom()
          break
        default:
          break
      }
    },

    showStudents(classId) {
      http
        .get(`/getuserInClass/${classId}`)
        .then(response => {
          console.log(classId)
          this.listUser = response
        })
        .catch(error => {
          this.listUser = []
          console.log(error.response.data.error)
        })
    },

    // ...

    addTeacher() {
      // Send a POST request to create a new classroom
      http
        .post('/classrooms', {
          classroom_name: this.className,
          coordinator_id: this.selectedTeacher
        })
        .then(response => {
          this.className = null
          this.selectedTeacher = null

          this.fetchClassrooms()
        })
        .catch(error => {
          console.log('Error creating classroom:', error)
        })
    },
    getTeacher() {
      http.get('users/get/teachers').then(response => {
        this.teacherList = response.data.data
      })
    },
    selectCordinator() {
      this.selectedTeacher = this.selectedTeacherId
      console.log(this.selectedTeacherId)
    },

    saveClassroom() {
      const newclassroom = {
        classroom_name: this.className,
        coordinator_id: this.selectedTeacher
      }

      if (this.editing) {
        http
          .put(`/classrooms/${this.editId}`, newclassroom)
          .then(() => {
            this.cancelForm()
            this.fetchClassrooms()
          })
          .catch(error => {
            console.log(error)
          })
      } else {
        http
          .post('/classrooms', newclassroom)
          .then(() => {
            this.cancelForm()
            this.fetchClassrooms()
            Swal.fire({
              title: 'Teacher added',
              icon: 'success',
              timer: 3000
            })
          })
          .catch(error => {
            console.log(error)
          })
      }
    },

    editClassroom(classroom) {
      this.formAction = 'Edit Classroom'
      this.editing = true
      this.editId = classroom.id
      this.className = classroom.classroom_name
      this.selectedTeacher = classroom.teacher_id
      this.dialog = true
    },

    updateClassroom() {
      const id = this.editId

      http
        .put(`/classrooms/${id}/update`, {
          classroom_name: this.className,
          teacher_id: this.selectedTeacher
        })
        .then(response => {
          this.fetchClassrooms()
          console.log('Classroom updated:', response.data)
          this.className = null
          this.selectedTeacher = null
          this.dialog = false
        })
        .catch(error => {
          console.log('Error updating classroom:', error)
        })
    },

    cancelForm() {
      this.formAction = 'Add Classroom'
      this.editing = false
      this.editId = null
      this.classroom = { className: '', teacher: '' }
      this.selectedTeacher = null
      this.dialog = false
    },

    deleteClassroom(id) {
      this.deleteCassroom(id).then(() => {
        this.getCassrooms()
      })
    }
    // getStudentInClass() {
    //   http
    //     .get(`/get-students`)
    //     .then(response => {
    //       response.data.data
    //     })
    //     .catch(error => {
    //       console.log(error)
    //     })
    // }
  },

  mounted() {
    // this.getStudentInClass()
    this.getTeacher()
  }
}
</script>

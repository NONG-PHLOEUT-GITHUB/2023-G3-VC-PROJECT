<template>
  <custom-title icon="mdi-chair-school">
    <template #right>
      <v-btn
        variant="outlined"
        append-icon="mdi-filter-multiple-outline"
        class="text-none me-4"
        color="primary"
        @click="toggleFilter = !toggleFilter"
        >Filters
      </v-btn>
      <v-btn variant="tonal" class="me-2 bg-green-darken-1" icon="mdi-file-excel"></v-btn>
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
                  :error-messages="classNameRole"
                  variant="outlined"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-select
                  label="Assigne teacher"
                  variant="outlined"
                  :items="teachers"
                  :item-title="fullName"
                  item-value="id"
                  clearable
                  multiple
                  chips
                  v-model="selectedTeachers"
                >
                </v-select>
              </v-col>
              <v-col cols="12">
                <v-select
                  label="Assign class coordinator"
                  variant="outlined"
                  :items="coordinators"
                  :item-title="fullName"
                  item-value="id"
                  clearable
                  v-model="coordinatorId"
                  chips
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
    <v-col v-if="classrooms.length !== 0" cols="12" md="3" v-for="classroom in classrooms">
      <v-card prepend-icon="mdi-chair-school" :title="classroom.classroom_name">
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
        <v-card-text>
          Total student: <strong>{{ classroom.student_count }}</strong
          ><br />
          Coordinator : <strong>{{ classroom.class_coordinator }}</strong>
        </v-card-text>
      </v-card>
    </v-col>
    <v-alert v-else text="Don't have classroom yet. Please create classroom." type="info"></v-alert>
  </v-row>
</template>

<script>
import { useClassroomStore } from '@/stores/classroom'
import { useTeacherStore } from '@/stores/teacher'
import { mapActions, mapState } from 'pinia'
export default {
  data() {
    return {
      dialog: false,
      className: '',
      formAction: 'Create new classroom',
      editing: false,
      editId: null,
      selectedTeachers: [],
      coordinatorId: null,
      classNameRole: '',
      items: [
        { action: 'details', title: 'Details', icon: 'mdi-eye' },
        { action: 'edit', title: 'Edite', icon: 'mdi-pencil' },
        { action: 'delete', title: 'Delete', icon: 'mdi-delete', color: 'red' }
      ]
    }
  },
  created() {
    this.getCassrooms()
    this.getCoordinatorClass()
    this.getTeachers()
  },
  computed: {
    ...mapState(useClassroomStore, ['classrooms']),
    ...mapState(useTeacherStore, ['coordinators', 'teachers']),
    fullName() {
      return function (item) {
        return item.first_name + ' ' + item.last_name
      }
    }
  },

  methods: {
    ...mapActions(useClassroomStore, [
      'getCassrooms',
      'deleteCassroom',
      'createClassroom',
      'getClassroomDetails',
      'updateClassroom'
    ]),
    ...mapActions(useTeacherStore, ['getCoordinatorClass', 'getTeachers']),
    onMenuClick(action, id) {
      switch (action) {
        case 'edit':
          this.editClassroom(id)
          break
        case 'delete':
          this.deleteClassroom(id)
          break
        case 'details':
          this.$router.push(`/classroom/${id}/details`)
          break
        default:
          break
      }
    },

    saveClassroom() {
      const newclassroom = {
        classroom_name: this.className.toUpperCase(),
        coordinator_id: this.coordinatorId,
        teacher_id: this.selectedTeachers
      }

      if (this.editing) {
        this.updateClassroom(newclassroom, this.editId)
          .then(() => {
            this.cancelForm()
            this.getCassrooms()
            this.$root.$notif('Create successfully', {
              type: 'success',
              color: 'primary'
            })
          })
          .catch(error => {
            console.log(error)
          })
      } else {
        this.createClassroom(newclassroom)
          .then(() => {
            this.cancelForm()
            this.getCassrooms()
            this.$root.$notif('Create successfully', {
              type: 'success',
              color: 'primary'
            })
          })
          .catch(error => {
            this.classNameRole = error.response.data.error
          })
      }
    },

    editClassroom(classroom) {
      this.getClassroomDetails(classroom).then(response => {
        this.editId = response.id
        this.className = response.classroom_name
        this.coordinatorId = response.coordinator
        this.selectedTeachers = response.teachers.map(teacher => teacher.id)
      })
      this.formAction = 'Edit Classroom'
      this.editing = true
      this.dialog = true
    },

    cancelForm() {
      this.formAction = 'Add Classroom'
      this.editing = false
      this.editId = null
      this.className = ''
      this.coordinatorId = null
      this.selectedTeachers = null
      this.dialog = false
    },

    deleteClassroom(id) {
      this.$root.$confirm({
        title: 'Are you sure?',
        message: "Are you sure you want to delete this classroom?",
        options: {
          agreeBtnText: 'Yes',
          type: 'error',
          color: 'error',
          width: 400
        },
        agree: () =>
          this.deleteCassroom(id).then(() => {
            this.getCassrooms()
            this.$root.$notif('Delete successfully', {
              type: 'success',
              color: 'primary'
            })
          })
      })
    }
  }
}
</script>

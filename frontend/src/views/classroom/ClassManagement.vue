<template>
  <custom-title icon="mdi-chair-school">
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
    <classroom-filter v-show="toggleFilter" @filter-applied="onFilterApplied" />
  </v-slide-y-reverse-transition>
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
                  :label="$t('classroom.form.className')"
                  v-model="className"
                  required
                  :error-messages="classNameRole"
                  variant="outlined"
                  color="textField"
                  :rules="[() => !!className || 'This field is required']"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-autocomplete
                  v-model="selectedTeachers"
                  :items="teachers"
                  :error-messages="teacherRole"
                  color="blue-grey-lighten-2"
                  :item-title="fullName"
                  item-value="id"
                  :label="$t('classroom.form.teacherName')"
                  chips
                  closable-chips
                  multiple
                  variant="outlined"
                  :rules="[
                    () => !!selectedTeachers || 'This field is required'
                  ]"
                >
                  <template v-slot:chip="{ props, item }">
                    <v-chip
                      v-bind="props"
                      :prepend-avatar="item.raw.profile"
                      :text="item.raw.first_name + ' ' + item.raw.last_name"
                    ></v-chip>
                  </template>

                  <template v-slot:item="{ props, item }">
                    <v-list density="compact">
                      <v-list-item
                        v-bind="props"
                        :prepend-avatar="item.raw.profile"
                        :title="item.raw.first_name + ' ' + item.raw.last_name"
                      ></v-list-item>
                    </v-list>
                  </template>
                </v-autocomplete>
              </v-col>
              <v-col cols="12">
                <v-autocomplete
                  v-model="coordinator"
                  :items="coordinators"
                  color="blue-grey-lighten-2"
                  clearable
                  :item-title="fullName"
                  item-value="coodinator_id"
                  :label="$t('classroom.form.coorName')"
                  chips
                  closable-chips
                  variant="outlined"
                  :rules="[() => !!coordinator || 'This field is required']"
                >
                  <template v-slot:chip="{ props, item }">
                    <v-chip
                      v-bind="props"
                      :prepend-avatar="item.raw.profile"
                      :text="item.raw.first_name + ' ' + item.raw.last_name"
                    ></v-chip>
                  </template>

                  <template v-slot:item="{ props, item }">
                    <v-list density="compact">
                      <v-list-item
                        v-bind="props"
                        :prepend-avatar="item.raw.profile"
                        :title="item.raw.first_name + ' ' + item.raw.last_name"
                      ></v-list-item>
                    </v-list>
                  </template>
                </v-autocomplete>
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
  <v-row dense>
    <v-col
      v-if="classrooms.length !== 0"
      cols="12"
      md="3"
      v-for="classroom in classrooms"
    >
      <v-card
        prepend-icon="mdi-chair-school"
        :title="classroom.classroom_name"
        border
        flat
      >
        <template v-slot:append>
          <v-menu>
            <template v-slot:activator="{ props }">
              <v-btn
                icon="mdi-dots-vertical"
                class="elevation-0"
                v-bind="props"
              ></v-btn>
            </template>

            <v-list density="compact" nav>
              <v-list-item
                v-for="(item, i) in items"
                :key="i"
                :value="item"
                @click="onMenuClick(item.action, classroom.id)"
                color="primary"
              >
                <template v-slot:append>
                  <v-icon :icon="item.icon" :color="item.color"></v-icon>
                </template>
                <v-list-item-title v-text="item.title"></v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </template>
        <v-card-text>
          <v-chip class="mb-2">
            {{ $t('dashboard.studentTotal') }} :
            <strong>{{ classroom.student_count }}</strong>
          </v-chip>
          <br />
          <v-avatar>
            <v-img alt="John" :src="classroom.coordinator_profile"></v-img>
          </v-avatar>

          <v-chip v-if="classroom.class_coordinator != null" color="primary">
            <strong>{{ classroom.class_coordinator }}</strong>
          </v-chip>
          <v-chip color="info" pill v-else>
            {{ $t('classroom.message.noCoordinator') }}
          </v-chip>
        </v-card-text>
      </v-card>
    </v-col>
    <v-alert v-else text="No class created." type="info"></v-alert>
  </v-row>
</template>

<script>
  import ClassroomFilter from '@/components/filters/ClassroomFilter.vue'
  import { useClassroomStore } from '@/stores/classroom'
  import { useTeacherStore } from '@/stores/teacher'
  import { mapActions, mapState } from 'pinia'
  export default {
    components: {
      ClassroomFilter
    },
    data() {
      return {
        dialog: false,
        toggleFilter: false,
        className: '',
        formAction: this.$t('classroom.createNew'),
        editing: false,
        editId: null,
        selectedTeachers: [],
        coordinator: [],
        classNameRole: '',
        teacherRole: '',
        filterCriteria: {}
      }
    },
    created() {
      this.getCassrooms(this.filterCriteria)
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
      },
      items() {
        return [
          {
            action: 'details',
            title: this.$t('btn.details'),
            icon: 'mdi-eye',
            color: 'secondary'
          },
          {
            action: 'edit',
            title: this.$t('btn.edit'),
            icon: 'mdi-pencil',
            color: 'primary'
          },
          {
            action: 'delete',
            title: this.$t('btn.delete'),
            icon: 'mdi-delete',
            color: 'red'
          }
        ]
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
        const formData = {
          classroom_name: this.className.toUpperCase(),
          coordinator_id: this.coordinator?.id || this.coordinator,
          teacher_id: this.selectedTeachers
        }

        if (this.editing) {
          this.updateClassroom(formData, this.editId)
            .then(() => {
              this.clearForm()
              this.getCassrooms(this.filterCriteria)
              this.$root.$notif(this.$t('alert.update'), {
                type: 'success',
                color: 'primary'
              })
            })
            .catch(error => {
              this.teacherRole = error.response.data.error
            })
        } else {
          this.createClassroom(formData)
            .then(() => {
              this.clearForm()
              this.getCassrooms(this.filterCriteria)
              this.$root.$notif(this.$t('alert.create'), {
                type: 'success',
                color: 'primary'
              })
            })
            .catch(error => {
              console.log(error)
              this.classNameRole = error.response.data.error
              this.teacherRole = error.response.data.error
            })
        }
      },

      editClassroom(id) {
        this.getClassroomDetails(id).then(response => {
          this.editId = response.id
          this.className = response.classroom_name
          this.coordinator = response.coordinator
          this.selectedTeachers = response.teachers.map(teacher => teacher.id)
        })
        this.formAction = this.$t('classroom.edit')
        this.editing = true
        this.dialog = true
      },

      clearForm() {
        this.editing = false
        this.editId = null
        this.className = ''
        this.coordinator = null
        this.selectedTeachers = null
        this.dialog = false
      },

      deleteClassroom(id) {
        this.$root.$confirm({
          title: 'Are you sure?',
          message: 'Are you sure you want to delete this classroom?',
          options: {
            agreeBtnText: 'Yes',
            type: 'error',
            color: 'error',
            width: 400
          },
          agree: () =>
            this.deleteCassroom(id).then(() => {
              this.getCassrooms(this.filterCriteria)
              this.$root.$notif(this.$t('alert.delete'), {
                type: 'success',
                color: 'primary'
              })
            })
        })
      },
      onFilterApplied(filterText) {
        this.filterCriteria = filterText
        this.getCassrooms(this.filterCriteria)
      }
    }
  }
</script>

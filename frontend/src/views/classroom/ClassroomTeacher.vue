<template>
  <custom-title icon="mdi-google-classroom">
    <template #right>
      <v-btn
        icon="mdi-filter-multiple-outline"
        variant="tonal"
        class="me-2 bg-primary"
        @click="toggleFilter = !toggleFilter"
      ></v-btn>
    </template>
  </custom-title>
  <div class="main">
    <v-row dense class="py-4">
      <v-col cols="12" md="7">
        <custom-sub-title icon="mdi-account-tie-woman">Class Coordinator</custom-sub-title>
        <v-card
          v-if="coordinator !== null"
          prepend-icon="mdi-chair-school"
          :title="coordinator.classroom_name"
          :subtitle="coordinator.student_count"
        >
          <v-card-actions>
            <v-btn
              color="teal-darken-4"
              :to="'/student/' + coordinator.id + '/feedback'"
              class="me-1 bg-primary"
            >
              Studen List
            </v-btn>
            <v-btn
              color="orange"
              class="bg-secondary"
              :to="`/attendance/` + coordinator.id + `/student`"
              text="Check attendance"
            ></v-btn>
            <v-btn
              class="bg-info"
              color="orange"
              :to="`/attendance/` + coordinator.id + `/student`"
              text="score report"
            ></v-btn>
            <v-btn
              class="bg-warning"
              color="orange"
              :to="`/attendance-report/` + coordinator.id + `/by-class`"
              text="attendance report"
            ></v-btn>
          </v-card-actions>
        </v-card>
        <v-alert v-else text="No class coordinator assigned yet." type="info"></v-alert>
      </v-col>
    </v-row>
    <custom-sub-title icon="mdi-account-tie">Classroom teaching</custom-sub-title>
    <v-row dense>
      <v-col
        v-if="teacherTeachingClass.length !== 0"
        cols="12"
        md="7"
        v-for="classroom in teacherTeachingClass"
      >
        <v-card
          prepend-icon="mdi-chair-school"
          :title="classroom.classroom_name"
          :subtitle="classroom.student_count"
        >
          <v-card-actions>
            <v-btn
              color="teal-darken-4"
              :to="'/student/' + classroom.id + '/feedback'"
              class="me-1 bg-primary"
            >
              Studen List
            </v-btn>
            <v-btn
              color="orange"
              class="bg-secondary"
              :to="`/attendance/` + classroom.id + `/student`"
              text="Check attendance"
            ></v-btn>
            <v-btn
              class="bg-info"
              color="orange"
              :to="`/attendance/` + classroom.id + `/student`"
              text="score report"
            ></v-btn>
            <v-btn
              class="bg-warning"
              color="orange"
              :to="`/attendance-report/` + classroom.id + `/by-class`"
              text="attendance report"
            ></v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      <v-alert v-else text="No class teaching assigned yet." type="info"></v-alert>
    </v-row>
  </div>
</template>

<script>
import { mapActions, mapState } from 'pinia'
import { useTeacherStore } from '@/stores/teacher'
export default {
  data() {
    return {}
  },
  created() {
    this.getTeacherClassTeaching()
  },
  computed: {
    ...mapState(useTeacherStore, ['teacherTeachingClass', 'coordinator'])
  },
  methods: {
    ...mapActions(useTeacherStore, ['getTeacherClassTeaching'])
  }
}
</script>

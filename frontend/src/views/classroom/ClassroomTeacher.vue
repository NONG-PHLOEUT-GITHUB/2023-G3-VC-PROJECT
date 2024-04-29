<template>
  <custom-title icon="mdi-google-classroom">
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
    </template>
  </custom-title>
  <div class="main">
    <v-row dense>
      <v-col cols="12" md="3" v-for="classroom in teacherTeachingClass">
        <v-card
          prepend-icon="mdi-chair-school"
          :title="classroom.classroom_name"
          :subtitle="classroom.student_count"
        >
          <v-card-actions>
            <v-btn color="teal-darken-4" :to="'/student/' + classroom.id + '/feedback'" class="me-1">
              Studen List
            </v-btn>
            <v-btn
              color="orange"
              :to="`/attendance/` + classroom.id + `/student`"
              text="Check attendance"
            ></v-btn>
          </v-card-actions>
          <!-- <v-card-text>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</v-card-text> -->
        </v-card>
      </v-col>
    </v-row>
    <!-- {{teacherTeachingClass}} -->
    <!-- <v-card
      v-for="classroom of classrooms"
      :key="classroom"
      class="card mx-auto mt-2"
      width="96%"
      prepend-icon="mdi-home"
      elevation="4"
    >
      <template v-slot:title> Grade : {{ classroom.class_name }}</template>
      <div class="action">
        <v-col cols="auto">
          <v-btn
            color="teal-darken-4"
            :to="{ path: '/student-score-report/' + classroom.id }"
            class="me-4"
          >
            <v-icon>mdi-chart-line</v-icon> Score report
          </v-btn>
          <v-btn color="teal-darken-4" :to="{ path: '//attendance-report/' + classroom.id + '/by-class'}">
            <v-icon>mdi-calendar-clock</v-icon> Attendance report
          </v-btn>
          <v-btn color="teal-darken-4" :to="{ path: '/feedback/' + classroom.id }" class="ms-4">
            <v-icon>mdi-poll</v-icon> Studen feedback
          </v-btn>
        </v-col>
      </div>
    </v-card> -->
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
    ...mapState(useTeacherStore, ['teacherTeachingClass'])
  },
  methods: {
    ...mapActions(useTeacherStore, ['getTeacherClassTeaching'])
  }
}
</script>

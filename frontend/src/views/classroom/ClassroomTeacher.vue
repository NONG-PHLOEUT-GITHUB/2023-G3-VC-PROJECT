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
        <custom-sub-title icon="mdi-account-tie-woman">{{ $t('classroom.coordinator') }}</custom-sub-title>
        <v-card v-if="coordinator !== null" prepend-icon="mdi-chair-school">
          <template v-slot:title>
            <span class="font-weight-black">Class: {{ coordinator.classroom_name }}</span>
          </template>
          <v-card-subtitle class="font-weight-black">
            Totl student: {{ coordinator.student_count }}
          </v-card-subtitle>
          <v-card-actions>
            <v-btn
              color="teal-darken-4"
              class="me-1 bg-primary text-none"
              @click="storeClassroomIdAndNavigate(coordinator.id)"
            > {{ $t('btn.studentList') }}
             
            </v-btn>
            <v-btn
              color="orange"
              class="bg-secondary text-none"
              :to="`/attendance/` + coordinator.id + `/student`"
              text="Check attendance"
            >{{ $t('btn.checkAtt') }}</v-btn>
            <v-btn
              class="bg-info text-none"
              color="orange"
              :to="`/attendance/` + coordinator.id + `/student`"
            >{{ $t('btn.scoreReport') }}</v-btn>
            <v-btn
              class="bg-warning text-none"
              color="orange"
              :to="`/attendance-report/` + coordinator.id + `/by-class`"
            >{{ $t('btn.attReport') }}</v-btn>
          </v-card-actions>
        </v-card>
        <v-alert v-else text="No class coordinator assigned yet." type="info"></v-alert>
      </v-col>
    </v-row>
    <custom-sub-title icon="mdi-account-tie">{{$t('classroom.cteaching')}}</custom-sub-title>
    <v-row dense>
      <v-col
        v-if="teacherTeachingClass.length !== 0"
        cols="12"
        md="7"
        v-for="classroom in teacherTeachingClass"
      >
        <v-card prepend-icon="mdi-chair-school">
          <template v-slot:title>
            <span class="font-weight-black">Class: {{ classroom.classroom_name }}</span>
          </template>
          <v-card-subtitle class="font-weight-black">
            Totl student: {{ classroom.student_count }}
          </v-card-subtitle>
          <v-card-actions>
            <!-- :to="'/student/' + classroom.id + '/feedback'" -->
            <v-btn
              color="teal-darken-4"
              class="me-1 bg-primary text-none"
              @click="storeClassroomIdAndNavigate(classroom.id)"
            >{{ $t('btn.studentList') }}
            </v-btn>
            <v-btn
              color="orange"
              class="bg-secondary text-none"
              :to="`/attendance/` + classroom.id + `/student`"
            >{{ $t('btn.checkAtt') }}</v-btn>
            <v-btn
              class="bg-info text-none"
              color="orange"
              :to="`/attendance/` + classroom.id + `/student`"
            >{{ $t('btn.scoreReport') }}</v-btn>
            <v-btn
              class="bg-warning text-none"
              color="orange"
              :to="`/attendance-report/` + classroom.id + `/by-class`"
            >{{ $t('btn.attReport') }}</v-btn>
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
    ...mapActions(useTeacherStore, ['getTeacherClassTeaching']),
    storeClassroomIdAndNavigate(classroomId) {
      // Store classroom.id in local storage
      localStorage.setItem('classroomId', classroomId);

      // Navigate to the desired URL
      this.$router.push(`/student/${classroomId}/feedback`);
    }
  }
}
</script>

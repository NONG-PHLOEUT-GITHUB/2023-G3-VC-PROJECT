<template>
  <custom-title icon="mdi-view-dashboard-edit-outline"></custom-title>
  <v-row class="mb-4">
    <v-col cols="12" md="4">
      <v-card class="mx-auto" subtitle="All class 12 in school" title="Class 12">
        <template v-slot:prepend>
          <v-avatar color="blue-darken-2">
            <v-icon icon="mdi-math-compass"></v-icon>
          </v-avatar>
        </template>
        <v-col>
          <h3>
            <strong>{{ classroomCounts['12'] }}</strong>
          </h3>
          <h5>
            <v-icon>mdi-gender-male</v-icon>30 <v-icon>mdi-gender-female</v-icon>30
          </h5>
        </v-col>
      </v-card>
    </v-col>
    <v-col cols="12" md="4">
      <v-card class="mx-auto" subtitle="All teachers in school" title="Class 11">
        <template v-slot:prepend>
          <v-avatar color="blue-darken-2">
            <v-icon icon="mdi-human-male-board-poll"></v-icon>
          </v-avatar>
        </template>
        <v-col>
          <h3>
            <strong>{{ classroomCounts['11'] }}</strong>
          </h3>
          <h5><v-icon>mdi-gender-male</v-icon>30 <v-icon>mdi-gender-female</v-icon>30</h5>
        </v-col>
      </v-card>
    </v-col>
    <v-col cols="12" md="4">
      <v-card class="mx-auto" subtitle="All classrooms in school" title="Class 10">
        <template v-slot:prepend>
          <v-avatar color="blue-darken-2">
            <v-icon icon="mdi-google-classroom"></v-icon>
          </v-avatar>
        </template>
        <v-col>
          <h3>
            <strong>{{ classroomCounts['10'] }}</strong>
          </h3>
          <h5>
            <v-icon>mdi-chair-rolling</v-icon>40
          </h5>
        </v-col>
      </v-card>
    </v-col>
  </v-row>

  <StudentMostAbsenceVue></StudentMostAbsenceVue>
</template>

<script>
import http from '@/api/api.js'
import StudentMostAbsenceVue from '@/components/dashboard/StudentMostAbsence.vue'
export default {
  components: {
    StudentMostAbsenceVue
  },
  data() {
    return {
      classroomCounts: {}
    }
  },
  mounted() {
    this.getClassroomCounts()
  },
  methods: {
    getClassroomCounts() {
      http
        .get('/getTotalOfEachClass')
        .then(response => {
          this.classroomCounts = response.data.data
          console.log(this.classroomCounts)
        })
        .catch(error => {
          console.log(error)
        })
    }
  }
}
</script>

<style scoped>
.main {
  width: 80%;
  margin-left: 19%;
}
.bar1 {
  width: 48%;
  border-left: solid teal 5px;
}
</style>
.js

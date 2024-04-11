<template>
  <custom-title></custom-title>
  <v-row>
    <v-card width="400" class="bar1 ms-4 user-total elevation-4" prepend-icon="mdi-school">
      <template v-slot:title> Class 10 </template>

      <v-card-text class="ms-14">
        <h5>Total : {{ classroomCounts['10'] }}</h5>
      </v-card-text>
    </v-card>
    <v-card width="400" class="bar1 ms-4 user-total elevation-4" prepend-icon="mdi-school">
      <template v-slot:title> Class 11 </template>

      <v-card-text class="ms-14">
        <h5>Total : {{ classroomCounts['11'] }}</h5>
      </v-card-text>
    </v-card>
    <v-card width="380" class="bar1 ms-4 user-total elevation-4" prepend-icon="mdi-school">
      <template v-slot:title> Class 12 </template>

      <v-card-text class="ms-14">
        <h5>Total : {{ classroomCounts['12'] }}</h5>
      </v-card-text>
    </v-card>

    <!-- <v-card max-width="450" variant="tonal">
      <v-card-title
        ><span class="text-h6 text-primary">{{
          $t('Dashboard.lastKeyFigures.overdueRevisions.title')
        }}</span></v-card-title
      >
      <v-card-text class="py-0">
        <v-row align="center">
          <v-col class="text-h2" cols="8">
            {{ overdueRevision.length }}
          </v-col>
          <v-col class="text-right" cols="4">
            <v-icon color="error" icon="mdi-clock-outline" size="65"></v-icon>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card> -->
  </v-row>

  <StudentMostAbsenceVue></StudentMostAbsenceVue>
</template>

<script>
import http from '@/api/api.js'
import StudentMostAbsenceVue from '../Student/StudentMostAbsence.vue'
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

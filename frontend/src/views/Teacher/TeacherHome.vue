<template>
  <teacher-dashboard></teacher-dashboard>
<<<<<<< HEAD
=======
  <div class="card-container">
    <v-row class="mt-7 ms-24">
      <v-card
        width="400"
        class="bar1 ms-4 user-total elevation-4"
        prepend-icon="mdi-school"
      >
        <template v-slot:title> Class 10 </template>

        <v-card-text class="ms-14">
          <h5>Total : {{ classroomCounts["10"] }}</h5>
        </v-card-text>
      </v-card>
      <v-card
        width="400"
        class="bar1 ms-4 user-total elevation-4"
        prepend-icon="mdi-school"
      >
        <template v-slot:title> Class 11 </template>

        <v-card-text class="ms-14">
          <h5>Total : {{ classroomCounts["11"] }}</h5>
        </v-card-text>
      </v-card>
      <v-card
        width="400"
        class="bar1 ms-4 user-total elevation-4"
        prepend-icon="mdi-school"
      >
        <template v-slot:title> Class 12 </template>

        <v-card-text class="ms-14">
          <h5>Total : {{ classroomCounts["12"] }}</h5>
        </v-card-text>
      </v-card>
    </v-row>
  </div>
>>>>>>> 7c698fb279bb789ebdf4d98e346ba347696014c9
  <div class="main">
    <StudentMostAbsenceVue></StudentMostAbsenceVue>
  </div>
</template>

<script>
<<<<<<< HEAD
=======
import http from "@/htpp.common.js";
>>>>>>> 7c698fb279bb789ebdf4d98e346ba347696014c9
import StudentMostAbsenceVue from "../Student/StudentMostAbsence.vue";
export default {
  components: {
    StudentMostAbsenceVue,
  },
<<<<<<< HEAD
=======
  data() {
    return {
      classroomCounts: {},
    };
  },
  mounted() {
    this.getClassroomCounts();
  },
  methods: {
    getClassroomCounts() {
      http
        .get("/getTotalOfEachClass")
        .then((response) => {
          this.classroomCounts = response.data.data;
          console.log(this.classroomCounts);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
>>>>>>> 7c698fb279bb789ebdf4d98e346ba347696014c9
};
</script>

<style scoped>
.main {
  width: 80%;
  margin-left: 18%;
<<<<<<< HEAD
=======
}
.card-container {
  padding: 10px;
  margin-left: 11%;
}
.bar1 {
  width: 48%;
  border-left: solid teal 5px;
>>>>>>> 7c698fb279bb789ebdf4d98e346ba347696014c9
}
</style>

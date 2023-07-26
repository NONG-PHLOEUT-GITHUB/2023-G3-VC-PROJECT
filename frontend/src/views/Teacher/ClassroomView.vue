<template>
<teacher-dashboard></teacher-dashboard>
<div class="main">
  <v-btn block  variant="outlined" size="large" color="">Class list</v-btn>

  <v-card v-for="classroom of classrooms" :key="classroom"
    class="card mx-auto mt-2"
    width="96%"
    prepend-icon="mdi-home"
  >
    <template v-slot:title> Grade : {{ classroom.class_name }}</template>
    <div class="action">
      <v-col cols="auto">
        <v-btn to="/monthly_report" class="me-4">
          <v-icon>mdi-chart-line</v-icon> Score report
        </v-btn>
        <v-btn to="/attendance_list">
          <v-icon>mdi-calendar-clock</v-icon> Attendance report</v-btn
        >
        <v-btn to="/feedback" class="ms-4">
          <v-icon>mdi-poll</v-icon> Studen feedback
        </v-btn>
      </v-col>
    </div>
    <!-- <v-card-text>
              This is content
            </v-card-text>  -->
    </v-card>
  </div>
</template>

<script>
import http from "@/htpp.common";
export default {
  data() {
    return {
      classrooms: [],
      class_name: "",
    };
  },
  methods: {
    getTeacherClassroom() {
      http.get("/v1/auth/user").then((response) => {
        this.classrooms = response.data.data.class_teacher;
        // this.classrooms.forEach((classroom) =>{
        //   console.log(classroom);
        // })
      });
    },
  },
  mounted() {
    this.getTeacherClassroom();
  },
};
</script>

<style>
.main {
  margin-left: 18%;
  margin-top: 15px;
}
</style>

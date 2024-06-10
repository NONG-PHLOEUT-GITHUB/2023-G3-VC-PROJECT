<template>
  <custom-title></custom-title>
  <v-data-table></v-data-table>
</template>

<script>
import http from "@/api/api";
export default {
  data() {
    return {
      attendanceData: [],
    };
  },
  mounted() {
    http
      .get("/getTeacherAttendance")
      .then((response) => {
        this.attendanceData = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>

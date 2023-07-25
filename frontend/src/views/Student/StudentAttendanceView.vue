<template>
  <student-dashboard />
  <v-card class="card mt-3">
    <v-tabs 
      v-model="tab"
      bg-color="deep-purple-darken-4"
      center-active
    >
      <v-tab value="1">January</v-tab>
      <v-tab value="2">February</v-tab>
      <v-tab value="3">March</v-tab>
      <v-tab value="4">April</v-tab>
      <v-tab value="5">May</v-tab>
      <v-tab value="6">June</v-tab>
      <v-tab value="7">July</v-tab>
      <v-tab value="8">August</v-tab>
      <v-tab value="9">September</v-tab>
      <v-tab value="10">October</v-tab>
      <v-tab value="11">November</v-tab>
      <v-tab value="12">December</v-tab>
    </v-tabs>
  </v-card>
  <v-card-text class="card">
      <v-window v-model="tab">
        <v-window-item value="1">
          <div class="table-responsive">
            <table class="table table-hover table-nowrap mt-2">
              <thead class="bg-primary">
                <tr>
                  <th scope="col" class="text-sm text-light">Date</th>
                  <th scope="col" class="text-sm text-light">status</th>
                  <th scope="col" class="text-sm text-light">Reason</th>
                  <th scope="col" class="text-sm text-light">Subject</th>
                  <th scope="col" class="text-sm text-light">Teacher</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="attendance of attendances"
                  :key="attendance"
                  class="border-2-dark"
                >
                  <td class="text-sm text-black">{{ attendance.date}}</td>
                  <td class="text-sm text-black">{{ attendance.status}}</td>
                  <td class="text-sm text-black">{{ attendance.reason}}</td>
                  <td class="text-sm text-black">{{ attendance.subject}}</td>
                  <td class="text-sm text-black">{{ attendance.teacher }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </v-window-item>

        <v-window-item value="2">
          Two
        </v-window-item>

        <v-window-item value="3">
          Three
        </v-window-item>
      </v-window>
  </v-card-text>
</template>
<script>
import http from '@/htpp.common'

export default {
  data: () => ({
    tab: null,
    isDownloading: false,
    isDetail: false,
    pdfUrl: null,
    url: "http://127.0.0.1:8000/api/getTeachers",
    attendances: []
  }),
  methods: {
    getAttendance() {
      http.get("/api/v1/auth/user").then((response) => {
        this.attendances = response.data.data.attendances;
        console.log('attendacne',response.data.data.attendances)
      });
    },
  },
  mounted() {
    this.getAttendance();
  },
}
</script>
  
<style scoped>
  @import "~vuetify/dist/vuetify.css";
.card{
  margin-left: 17%;
}
.table th {
  font-size: 20px;
}
</style>
  




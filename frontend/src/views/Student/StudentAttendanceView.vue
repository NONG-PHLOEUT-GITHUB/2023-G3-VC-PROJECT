<template>
  <student-dashboard/>
  <h3 class="title mb-2">MY ATTENDANCES RECORDS</h3>
  <v-card class="card mt-3" v-if="displayTabs">
    <v-tabs
      v-model="tab"
      bg-color="deep-purple-darken-4"
      center-active
    >
      <v-tab v-for="(month, index) in monthsWithAttendance" :key="month" :value="index + 1">
        {{ month }}
      </v-tab>
    </v-tabs>
  </v-card>

  <v-card-text class="card">
    <v-window v-model="tab">
      <v-window-item v-for="(month, index) in monthsWithAttendance" :key="month" :value="index + 1">
        <div class="table-responsive">
          <table class="table table-hover table-nowrap mt-2">
            <thead class="bg-primary">
              <tr>
                <th scope="col" class="text-sm text-light">Date</th>
                <th scope="col" class="text-sm text-light">Status</th>
                <th scope="col" class="text-sm text-light">Reason</th>
              </tr>
            </thead>
            <tbody>
              <template v-if="getAttendanceByMonth(index + 1).length === 0">
                <tr>
                  <td colspan="5" class="text-center text-md text-dark">There is no absent yet in this month</td>
                </tr>
              </template>
              <template v-else>
                <tr
                  v-for="attendance of getAttendanceByMonth(index + 1)"
                  :key="attendance"
                  class="border-2-dark"
                >
                  <td class="text-sm text-black">{{ attendance.date }}</td>
                  <td class="text-sm text-red">{{ attendance.attendance_status }}</td>
                  <td class="text-sm text-black">{{ attendance.reason }}</td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
      </v-window-item>
    </v-window>
  </v-card-text>
</template>

<script>
import http from '@/htpp.common'

export default {
  data: () => ({
    tab: null,
    attendances: []
  }),
  computed: {
    months() {
      return [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
      ];
    },
    attendancesByMonth() {
      const attendancesByMonth = {};
      for (const attendance of this.attendances) {
        const month = new Date(attendance.date).getMonth() + 1;
        if (!attendancesByMonth[month]) {
          attendancesByMonth[month] = [];
        }
        attendancesByMonth[month].push(attendance);
      }
      return attendancesByMonth;
    },
    monthsWithAttendance() {
      return this.months.filter(month => {
        return this.attendancesByMonth[month.indexOf(month) + 1]?.length;
      });
    },
    displayTabs() {
      return this.monthsWithAttendance.length > 0;
    },
  },
  methods: {
    getAttendance() {
      http.get("/v1/auth/user").then((response) => {
        this.attendances = response.data.data.attendances;
        console.log(this.attendances);
      });
    },
    getAttendanceByMonth(month) {
      return this.attendances.filter((attendance) => {
        const attendanceMonth = new Date(attendance.date).getMonth() + 1;
        return attendanceMonth === month;
      });
    },
  },
  mounted() {
    this.getAttendance();
  },
};
</script>

<style scoped>
@import "~vuetify/dist/vuetify.css";
.card {
  margin-left: 17%;
}
.table th {
  font-size: 20px;
}
.title {
  margin-left: 18%;
}
</style>
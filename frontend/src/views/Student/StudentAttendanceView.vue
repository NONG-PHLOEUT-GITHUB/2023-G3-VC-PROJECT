<template>
  <student-dashboard />
  <h3 class="title mb-2">MY ATTENDANCES RECORDS</h3>
  <v-card class="card mt-3">
    <v-tabs v-model="tab" bg-color="deep-purple-darken-4" center-active>
      <v-tab
        v-for="(month, index) in monthsWithAttendance"
        :key="month"
        :value="index + 1"
      >
        {{ month }}
      </v-tab>
    </v-tabs>
  </v-card>
  <v-card-text class="card">
    <v-window v-model="tab">
      <v-window-item
        v-for="(month, index) in monthsWithAttendance"
        :key="month"
        :value="index + 1"
      >
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
                  <td colspan="3" class="text-center text-md text-dark">
                    There is no attendance yet in this month
                  </td>
                </tr>
              </template>
              <template v-else>
                <tr
                  v-for="attendance in getAttendanceByMonth(index + 1)"
                  :key="attendance.id"
                  class="border-2-dark"
                >
                  <td class="text-sm text-black">{{ attendance.date }}</td>
                  <td class="text-sm text-red">{{ attendance.status }}</td>
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
import http from "@/htpp.common";

export default {
  data: () => ({
    tab: null,
    attendances: [],
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
        "December",
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
      const monthsWithAttendance = [];
      for (let i = 1; i <= 12; i++) {
        if (this.attendancesByMonth[i]?.length) {
          monthsWithAttendance.push(this.months[i - 1]);
        } else {
          monthsWithAttendance.push(
            this.months[i - 1] 
          );
        }
      }
      return monthsWithAttendance;
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
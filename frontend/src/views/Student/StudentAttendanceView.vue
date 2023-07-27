<template>
<<<<<<< HEAD
  <student-dashboard></student-dashboard>
  <div>
    <h3 class="text">ABSENCE MONTHLY RECORD</h3>
    <v-card class="card mt-3">
      <v-tabs v-model="tab" bg-color="primary">
        <v-tab v-for="(month, index) in months" :key="index" :value="index + 1">
          {{ month }}
        </v-tab>
      </v-tabs>
      <v-card-text class="container">
        <v-window v-model="tab">
          <v-window-item
            v-for="(month, index) in months"
            :key="index"
            :value="index + 1"
          >
            <div class="table-responsive">
              <table class="table table-hover table-nowrap">
                <thead>
                  <tr>
                    <th scope="col" class="text-sm text-primary">Date</th>
                    <th scope="col" class="text-sm text-primary">Status</th>
                    <th scope="col" class="text-sm text-primary">Reason</th>
                    <th scope="col" class="text-sm text-primary">Subject</th>
                    <th scope="col" class="text-sm text-primary">Teacher</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(detail, index) in filteredAttendanceDetails"
                    :key="index"
                  >
                    <td class="text-sm text-black">{{ detail.date }}</td>
                    <td class="text-sm text-black">
                      {{ detail.attendance_status }}
                    </td>
                    <td class="text-sm text-black">{{ detail.reason }}</td>
                    <td class="text-sm text-black">
                      {{ detail.subject_name }}
                    </td>
                    <td class="text-sm text-black">
                      {{ detail.teacher_name }}
                    </td>
                  </tr>
                  <tr v-if="filteredAttendanceDetails.length === 0">
                    <td colspan="5" class="text-center text-base text-dark">
                      No absence records for this month.
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </v-window-item>
        </v-window>
      </v-card-text>
    </v-card>
  </div>
=======
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
>>>>>>> 86da5af12b08815e9cce4d174a5cc2ae30b30d6a
</template>

<script>
import http from "@/htpp.common.js";

export default {
<<<<<<< HEAD
  data() {
    return {
      tab: 1,
      months: [
=======
  data: () => ({
    tab: null,
    attendances: []
  }),
  computed: {
    months() {
      return [
>>>>>>> 86da5af12b08815e9cce4d174a5cc2ae30b30d6a
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
<<<<<<< HEAD
        "December",
      ],
      attendanceDetails: [],
    };
  },
  computed: {
    filteredAttendanceDetails() {
      return this.attendanceDetails.filter(
        (detail) => parseInt(detail.date.split("-")[1]) === this.tab
      );
    },
  },
  methods: {
    getAttendanceDetails() {
      http.get("/api/v1/auth/user").then((response) => {
        this.attendanceDetails = response.data.data.attendances;
=======
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
>>>>>>> 86da5af12b08815e9cce4d174a5cc2ae30b30d6a
      });
    },
  },
  mounted() {
    this.getAttendanceDetails();
  },
};
</script>

<style scoped>
<<<<<<< HEAD
=======
@import "~vuetify/dist/vuetify.css";
>>>>>>> 86da5af12b08815e9cce4d174a5cc2ae30b30d6a
.card {
  margin-left: 17%;
}
.text {
  margin-left: 47%;
  padding: 1%;
}
.container {
  padding: 10px;
}

.table th {
  font-size: 20px;
}
<<<<<<< HEAD
=======
.title {
  margin-left: 18%;
}
>>>>>>> 86da5af12b08815e9cce4d174a5cc2ae30b30d6a
</style>
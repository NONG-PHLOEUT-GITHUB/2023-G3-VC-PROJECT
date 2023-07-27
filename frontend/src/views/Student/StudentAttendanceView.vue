<template>
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
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(detail, index) in filteredAttendanceDetails"
                    :key="index"
                  >
                    <td class="text-sm text-black">{{ detail.date }}</td>
                    <td class="text-sm text-black">
                      {{ detail.status }}
                    </td>
                    <td class="text-sm text-black">{{ detail.reason }}</td>
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
</template>

<script>
import http from "@/htpp.common.js";
export default {
  data() {
    return {
      tab: 1,
      months: [
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
      http
        .get("/v1/auth/user")
        .then((response) => {
          this.attendanceDetails = response.data.data.attendances;
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },


  mounted() {
    this.getAttendanceDetails();
  },

};
</script>

<style scoped>
.card {
  margin-left: 17%;
}
.text {
  margin-left: 47%;
  padding: 1%;
}
.container {
  padding: 5px;
}

.table th {
  font-size: 20px;
}
</style>
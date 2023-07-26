<template>
<<<<<<< HEAD
  <student-dashboard/>
  <h3 class="title mb-2">MY SCORES RECORDS</h3>
  <v-card class="card mt-3" v-if="displayTabs">
    <v-tabs
      v-model="tab"
      bg-color="deep-purple-darken-4"
      center-active
    >
      <v-tab v-for="(month) in scoresByMonthWithSummary" :key="month.month" :value="month.month">
        {{ months[month.month - 1] }}
      </v-tab>
    </v-tabs>
  </v-card>

  <v-card-text class="card">
    <v-window v-model="tab">
      <v-window-item v-for="(month) in scoresByMonthWithSummary" :key="month.month" :value="month.month">
        <div class="table-responsive">
          <table class="table table-hover table-nowrap mt-2">
            <thead class="bg-primary">
              <tr>
                <th scope="col" class="text-sm text-light">Subject</th>
                <th scope="col" class="text-sm text-light">Score</th>
                <th scope="col" class="text-sm text-light">Grade</th>
                <th scope="col" class="text-sm text-light">Status</th>
              </tr>
            </thead>
            <tbody>
              <template v-if="month.scores.length === 0">
                <tr>
                  <td colspan="5" class="text-center text-md text-dark">There is no score yet in this month</td>
                </tr>
              </template>
              <template v-else>
                <tr
                  v-for="score of month.scores"
                  :key="score.id"
                  class="border-2-dark"
                >
                  <!-- <td class="text-sm text-black">{{ score.subject_id }}</td> -->
                  <td v-if="score.subject_id == 1" class="text-sm text-black">Khmer</td>
                  <td v-if="score.subject_id == 2" class="text-sm text-black">Math</td>
                  <td v-if="score.subject_id == 3" class="text-sm text-black">English</td>
                  <td v-if="score.subject_id == 4" class="text-sm text-black">History</td>
                  <td v-if="score.subject_id == 5" class="text-sm text-black">Biology</td>
                  <td v-if="score.subject_id == 6" class="text-sm text-black">Geography</td>
                  <td v-if="score.subject_id == 7" class="text-sm text-black">Earth Science</td>
                  <td v-if="score.subject_id == 8" class="text-sm text-black">Morality-Civics</td>
                  <td v-if="score.subject_id == 9" class="text-sm text-black">Chemisty</td>
                  <td v-if="score.subject_id == 10" class="text-sm text-black">Physics</td>
                  <td v-if="score.subject_id == 11" class="text-sm text-black">Sport</td>
                  <td v-if="score.subject_id == 12" class="text-sm text-black">ICT (information communication technology)</td>

                  <td v-if="score.score < 25" class="text-sm text-red">{{ score.score }}</td>
                  <td v-if="score.score >= 25 && score.score < 40" class="text-sm text-yellow">{{ score.score }}</td>
                  <td v-else class="text-sm text-green">{{ score.score }}</td>

                  <td v-if="(score.subject_id == 1 || score.subject_id == 2) && score.score < 50" class="text-sm text-red">F</td>
                  <td v-if="(score.subject_id == 1 || score.subject_id == 2) && score.score >= 50 && score.score < 60" class="text-sm text-yellow">E</td>
                  <td v-if="(score.subject_id == 1 || score.subject_id == 2) && score.score >= 60 && score.score < 70" class="text-sm text-yellow">D</td>
                  <td v-if="(score.subject_id == 1 || score.subject_id == 2) && score.score >= 70 && score.score < 80" class="text-sm text-yellow">C</td>
                  <td v-if="(score.subject_id == 1 || score.subject_id == 2) && score.score >= 80 && score.score < 90" class="text-sm text-green">B</td>
                  <td v-if="(score.subject_id == 1 || score.subject_id == 2) && score.score >= 90 && score.score < 100" class="text-sm text-green">A</td>
                  
                  <td v-if="score.subject_id > 2 && score.score < 25" class="text-sm text-red">F</td>
                  <td v-if="score.subject_id > 2 && score.score >= 25 && score.score < 30" class="text-sm text-yellow">E</td>
                  <td v-if="score.subject_id > 2 && score.score >= 30 && score.score < 35" class="text-sm text-yellow">D</td>
                  <td v-if="score.subject_id > 2 && score.score >= 35 && score.score < 40" class="text-sm text-yellow">C</td>
                  <td v-if="score.subject_id > 2 && score.score >= 40 && score.score < 45" class="text-sm text-green">B</td>
                  <td v-if="score.subject_id > 2 && score.score >= 45 && score.score < 50" class="text-sm text-green">A</td>

                  <td v-if="score.score < 25" class="text-sm text-red">Failed</td>
                  <td v-else class="text-sm text-green">Passed</td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
        <div class="total mb-5 mt-5">
          <h4 class="mb-2">Total Score: {{ month.total }}</h4>
          <h4 class="mb-2">Average: {{ month.average }}</h4>
          <h4 class="mb-2">Grade: {{ month.grade }}</h4>
          <h4 class="mb-2">Status: {{ month.status }}</h4>
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
    user: [],
    scores: [],
    subjects: [],
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
    scoresByMonth() {
      const scoresByMonth = {};
      for (const score of this.scores) {
        const month = new Date(score.month).getMonth() + 1;
        if (!scoresByMonth[month]) {
          scoresByMonth[month] = [];
        }
        scoresByMonth[month].push(score);
      }
      return scoresByMonth;
    },
    scoresByMonthWithSummary() {
      const scoresByMonth = {};
      for (const score of this.scores) {
        const month = new Date(score.month).getMonth() + 1;
        if (!scoresByMonth[month]) {
          scoresByMonth[month] = [];
        }
        scoresByMonth[month].push(score);
      }

      const scoresByMonthArray = Object.entries(scoresByMonth).map(([month, scores]) => {
        const total = scores.reduce((acc, score) => acc + score.score, 0);
        const average = (total / (scores.length + 2)).toFixed(3);
        // const average = (total / 10).toFixed(3);
        const grade = average <= 25 ? "F" : average <= 30 ? "E" : average <= 35 ? "D" : average <= 40 ? "C" : average <= 47 ? "B" : "A";
        const status = average <= 25 ? "Fail" : "Pass";
        return {
          month: parseInt(month),
          scores,
          total,
          average,
          grade,
          status,
        };
      });

      return scoresByMonthArray.sort((a, b) => a.month - b.month);
    },
    displayTabs() {
      return this.scoresByMonthWithSummary.length > 0;
    },
  },
  methods: {
    getScore() {
      http.get("/api/v1/auth/user").then((response) => {
        this.scores = response.data.data.scores;
        console.log(this.scores);
      });
    },
    getScoreByMonth(month) {
      return this.scores.filter((score) => {
        const scoreMonth = new Date(score.month).getMonth() + 1;
        return scoreMonth === month;
      }).map((score) => {
        const subject = this.subjects ? this.subjects.find((subject) => subject.id === score.subject_id) : null;
        return {
          ...score,
          subject_name: subject ? subject.subject_name : "Unknown Subject",
        };
      });
    },
  },
  mounted() {
    this.getScore();
=======
<student-dashboard></student-dashboard>
  <v-card class="card">
    <v-tabs v-model="tab" bg-color="primary">
      <v-tab v-for="month in months" :key="month.value" :value="month.value">{{ month.name }}</v-tab>
    </v-tabs>
    <v-card-text>
      <v-window v-model="tab">
        <v-window-item value="one">
          <v-table fixed-header height="300px">
            <thead>
              <tr>
                <th class="text-left">Khhmer</th>
                <th class="text-left">Math</th>
                <th class="text-left">Physic</th>
                <th class="text-left">Chemistry</th>
                <th class="text-left">Computer</th>
                <th class="text-left">Math</th>
                <th class="text-left">Computer</th>
                <th class="text-left">Math</th>
                <th class="text-left">Total</th>
                <th class="text-left">Average</th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr v-for="item in desserts" :key="item.name">
                <td>{{ item.name }}</td>
                <td>{{ item.calories }}</td>
              </tr> -->
              <tr>
                <td>50</td>
                <td>50</td>
                <td>50</td>
                <td>50</td>
                <td>50</td>
                <td>50</td>
                <td>50</td>
                <td>50</td>
                <td>50</td>
                <td>50</td>
              </tr>
            </tbody>
          </v-table>
        </v-window-item>
      </v-window>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      tab: "one",
      months: [
        { name: "January", value: "one" },
        { name: "February", value: "Two" },
        { name: "March", value: "three" },
        { name: "April", value: "four" },
        { name: "May", value: "five" },
        { name: "June", value: "six" },
        { name: "July", value: "seven" },
        { name: "August", value: "eight" },
        { name: "September", value: "nine" },
        { name: "October", value: "ten" },
        { name: "November", value: "eleven" },
        { name: "December", value: "twelve" },
      ],
    };
>>>>>>> 0d125bbe793f5b90c10e6877c2d5902b64aab8b9
  },
};
</script>

<<<<<<< HEAD
<style>
@import "~vuetify/dist/vuetify.css";
.card {
  margin-left: 17%;
=======
  <style scoped>
@import "~vuetify/dist/vuetify.css";

.sheet {
  margin-top: 10px;
  margin-left: 19%;
}
.card{
  margin-left: 16%;
  padding: 2%;
>>>>>>> 0d125bbe793f5b90c10e6877c2d5902b64aab8b9
}
.table th {
  font-size: 20px;
}
<<<<<<< HEAD
.title{
  margin-left: 18%;
}
=======
>>>>>>> 0d125bbe793f5b90c10e6877c2d5902b64aab8b9
</style>
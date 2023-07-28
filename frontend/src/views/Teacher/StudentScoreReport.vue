<template>
  <teacher-dashboard></teacher-dashboard>
  <div class="main mt-3">
    <h3 class="text">Score monthly reports</h3>
        <div class="table-responsive">
            <table class="table table-hover table-nowrap">
            <thead class="bg-primary">
                <tr>
                <th class="fs-7 text-white">NO</th>
                <th class="fs-7 text-white">Name</th>
                <th class="fs-7 text-white">Gender</th>
                <th class="fs-7 text-white">Khmer</th>
                <th class="fs-7 text-white">Math</th>
                <th class="fs-7 text-white">Eng</th>
                <th class="fs-7 text-white">His</th>
                <th class="fs-7 text-white">Bio</th>
                <th class="fs-7 text-white">Geo</th>
                <th class="fs-7 text-white">Es</th>
                <th class="fs-7 text-white">Mc</th>
                <th class="fs-7 text-white">C</th>
                <th class="fs-7 text-white">P</th>
                <th class="fs-7 text-white">Sport</th>
                <th class="fs-7 text-white">ICT</th>
                <th class="fs-7 text-white">Total</th>
                <th class="fs-7 text-white">Average</th>
                <th class="fs-7 text-white">Grade</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(student, index) of allStudents" :key="index">
                <td>{{ index + 1 }}</td>
                <td>{{ student.first_name + " " + student.last_name }}</td>
                <td>{{ student.gender }}</td>

                <td v-for="scores of student.scores" :key="scores">{{ scores.score }}</td>

                <td v-if="student.scores.length > 0 && getTotal(student.id) > 350" class="font-weight-bold text-green">{{ getTotal(student.id) }}</td>
                <td v-else class="font-weight-bold text-red">{{ getTotal(student.id) }}</td>

                <td v-if="student.scores.length > 0 && getAverage(student.id) > 25.00" class="font-weight-bold text-green">{{ getAverage(student.id) }}</td>
                <td v-else class="font-weight-bold text-red">{{ getAverage(student.id) }}</td>

                <td v-if="getAverage(student.id) < 25.00" class="font-weight-bold text-red">F</td>
                <td v-if="getAverage(student.id) >= 25 && getAverage(student.id) < 30" class="font-weight-bold text-green">E</td>
                <td v-if="getAverage(student.id) >= 30 && getAverage(student.id) < 35" class="font-weight-bold text-green">D</td>
                <td v-if="getAverage(student.id) >= 35 && getAverage(student.id) < 40" class="font-weight-bold text-green">C</td>
                <td v-if="getAverage(student.id) >= 40 && getAverage(student.id) < 47" class="font-weight-bold text-green">B</td>
                <td v-if="getAverage(student.id) >= 47 && getAverage(student.id) <= 50" class="font-weight-bold text-green">A</td>

                </tr>
            </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import http from "@/htpp.common";

export default {
  data() {
    return {
      allStudents: [],
      tab: 1,
    };
  },
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
  },
  methods: {
    getStudents(id) {
      http
        .get(`/getAllStudents/${id}`)
        .then((response) => {
          this.allStudents = response.data.data;
          this.allStudents.forEach((element) => {
            console.log(element.students);
            this.allStudents = element.students;
          });
          console.log(this.allStudents);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getTotal(id){
        let total = 0;
        this.allStudents.forEach(student => {
            if (student.id == id) {
                student.scores.forEach(element => {
                    total += element.score
                });
            }
        });
        return total;
    },
    getAverage(id){
        return (this.getTotal(id)/ 14).toFixed(3);
    },
  },
  mounted() {
    const id = this.$route.params.id;
    this.getStudents(id);
  },
};
</script>
<style scoped>
</style>



<!-- <template>
  <teacher-dashboard />
  <h3 class="title mt-3">Students score monthly reports</h3>
  <v-card class="card mt-3" v-if="displayTabs">
    <v-tabs v-model="tab" bg-color="deep-purple-darken-4" center-active>
      <v-tab v-for="month in months" :key="month">{{ month }}</v-tab>
    </v-tabs>
  </v-card>
  <v-card-text class="card">
    <v-window v-model="tab">
      <v-window-item
        v-for="(month, index) in months"
        :key="index"
        :value="month"
      >
        <div class="table-responsive">
          <table class="table table-hover table-nowrap mt-2">
            <thead class="bg-light">
              <tr>
                <th class="fs-7 text-black">NO</th>
                <th class="fs-7 text-black">Name</th>
                <th class="fs-7 text-black">Gender</th>
                <th
                  v-for="subject in subjects"
                  :key="subject"
                  class="fs-7 text-black"
                >
                  {{ subject }}
                </th>
                <th class="fs-7 text-black">Total</th>
                <th class="fs-7 text-black">Average</th>
                <th class="fs-7 text-black">Grade</th>
              </tr>
            </thead>
            <tbody>
              <template v-if="allStudents.length === 0">
                <tr>
                  <td colspan="5" class="text-center text-md text-dark">
                    There is no student data yet
                  </td>
                </tr>
              </template>
              <template v-else>
                <tr
                  v-for="(student, index) in allStudents"
                  :key="student.id"
                  class="border-2-dark"
                >
                  <td>{{ index + 1 }}</td>
                  <td>{{ student.first_name }} {{ student.last_name }}</td>
                  <td>{{ student.gender }}</td>
                  <td v-for="subject in subjects" :key="subject">
                    {{ getScoreByMonth(student, month, subject) }}
                  </td>
                  <td>{{ getTotalScore(student) }}</td>
                  <td>{{ getAverageScore(student) }}</td>
                  <td>{{ getGrade(student) }}</td>
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
        user: [],
        scores: [],
        allStudents: [],
        subjects: [
        'Khmer',
        'Math',
        'Eng',
        'His',
        'Bio',
        'Geo',
        'Es',
        'Mc',
        'C',
        'P',
        'Sport',
        'ICT'
        ]
    }),

    computed: {
        months() {
            return [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
            ]
        },
        scoresByMonth() {
            const scoresByMonth = {}
            for (const score of this.scores) {
            const month = new Date(score.month).getMonth() + 1
            if (!scoresByMonth[month]) {
                scoresByMonth[month] = []
            }
            scoresByMonth[month].push(score)
            }
            return scoresByMonth
        },
        displayTabs() {
            return this.allStudents.length > 0
        }
    },

    methods: {
        getScore(id) {
        http
            .get(`/getAllStudents/${id}`)
            .then((response) => {
            let allTheStudents = response.data.data
            allTheStudents.forEach((element) => {
                console.log(element.students)
                this.allStudents = element.students
                element.students.forEach((element) => {
                this.scores.push(element.scores)
                })
            })
            console.log(this.allStudents)
            console.log(this.scores)
            })
            .catch((error) => {
            console.log(error)
            })
        },

        getScoreByMonth(student, month, subject) {
            const monthScores = this.scores.filter(
                (score) =>
                new Date(score.month).getMonth() + 1 === this.months.indexOf(month) + 1 &&
                score.user_id === student.id &&
                score.subject_id === subject
            )
            if (monthScores.length === 0) {
                return '-'
            } else {
                return monthScores.map((score) => score.score).join(', ')
            }
        },
        getTotalScore(student) {
            const studentScores = this.scores.filter((score) => score.user_id === student.id)
            return studentScores.reduce((total, score) => total + score.score, 0)
            },
            getAverageScore(student) {
            const studentScores = this.scores.filter((score) => score.user_id === student.id)
            return (studentScores.reduce((total, score) => total + score.score, 0) / studentScores.length).toFixed(2)
        },
        getGrade(student) {
            const averageScore = this.getAverageScore(student)
            if (averageScore >= 90) {
                return 'A'
            } else if (averageScore >= 80) {
                return 'B'
            } else if (averageScore >= 70) {
                return 'C'
            } else if (averageScore >= 60) {
                return 'D'
            } else {
                return 'F'
            }
            },
        },
    mounted() {
        this.getScore()
    }
}
</script>

<style scoped>
@import "~vuetify/dist/vuetify.css";
.card {
  margin-left: 17%;
}
.title {
  margin-left: 18%;
}
</style> -->

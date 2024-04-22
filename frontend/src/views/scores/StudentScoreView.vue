<template>
  <custom-title></custom-title>

  <v-data-table-server
    v-model:items-per-page="itemsPerPage"
    :headers="headers"
    :items="serverItems"
    :items-length="totalItems"
    :loading="loading"
    :search="search"
    item-value="name"
    @update:options="loadItems"
  ></v-data-table-server>
</template>

<script>
import http from '@/api/api'

export default {
  data: () => ({
    tab: null,
    user: [],
    scores: [],
    subjects: [],
    monthsWithAttendance: [
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
    ],
    headers: [
        {
          title: 'Dessert (100g serving)',
          align: 'start',
          sortable: false,
          key: 'name',
        },
        { title: 'Calories', key: 'calories', align: 'end' },
        { title: 'Fat (g)', key: 'fat', align: 'end' },
        { title: 'Carbs (g)', key: 'carbs', align: 'end' },
        { title: 'Protein (g)', key: 'protein', align: 'end' },
        { title: 'Iron (%)', key: 'iron', align: 'end' },
      ],
  }),
  computed: {
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
    scoresByMonthWithSummary() {
      const scoresByMonth = {}
      for (const score of this.scores) {
        const month = new Date(score.month).getMonth() + 1
        if (!scoresByMonth[month]) {
          scoresByMonth[month] = []
        }
        scoresByMonth[month].push(score)
      }

      const scoresByMonthArray = Object.entries(scoresByMonth).map(([month, scores]) => {
        const total = scores.reduce((acc, score) => acc + score.score, 0)
        const average = (total / (scores.length + 2)).toFixed(3)
        // const average = (total / 10).toFixed(3);
        const grade =
          average <= 25
            ? 'F'
            : average <= 30
              ? 'E'
              : average <= 35
                ? 'D'
                : average <= 40
                  ? 'C'
                  : average <= 47
                    ? 'B'
                    : 'A'
        const status = average <= 25 ? 'Fail' : 'Pass'
        return {
          month: parseInt(month),
          scores,
          total,
          average,
          grade,
          status
        }
      })

      return scoresByMonthArray.sort((a, b) => a.month - b.month)
    },
    displayTabs() {
      return this.scoresByMonthWithSummary.length > 0
    }
  },
  methods: {
    getScore() {
      // http.get('/v1/auth/user').then(response => {
      //   this.scores = response.data.data.scores
      //   console.log(response.data.data)
      // })
    },
    getScoreByMonth(month) {
      return this.scores
        .filter(score => {
          const scoreMonth = new Date(score.month).getMonth() + 1
          return scoreMonth === month
        })
        .map(score => {
          const subject = this.subjects
            ? this.subjects.find(subject => subject.id === score.subject_id)
            : null
          return {
            ...score,
            subject_name: subject ? subject.subject_name : 'Unknown Subject'
          }
        })
    }
  },
  mounted() {
    this.getScore()
  }
}
</script>

<style scoped>
@import '~vuetify/dist/vuetify.css';
.card {
  margin-left: 17%;
}
.table th {
  font-size: 20px;
}
.title {
  margin-left: 18%;
}
.thead {
  background: #004d40;
}
</style>

<template>
  <custom-title icon="mdi-chart-box-plus-outline"></custom-title>
{{ studentScores }}

  <v-data-table
    :headers="headers"
    :items="serverItems"
    :loading="loading"
    item-value="name"
    class="elevation-1"
  ></v-data-table>
</template>

<script>
import { mapActions, mapState } from 'pinia'
import { useAuthStore } from '@/stores/auth'
export default {
  data: () => ({
    tab: null,
    user: [],
    scores: [],
    subjects: [],
    loading: false,
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
    serverItems: [
      {
        khmer: 85,
        math: 78,
        eng: 90,
        his: 82,
        bio: 88,
        geo: 75,
        es: 70,
        mc: 85,
        c: 80,
        p: 92,
        sport: 95,
        ict: 88,
        total: 990,
        average: 84.3,
        grade: 'A'
      },
      {
        khmer: 92,
        math: 85,
        eng: 88,
        his: 78,
        bio: 90,
        geo: 85,
        es: 72,
        mc: 80,
        c: 85,
        p: 88,
        sport: 90,
        ict: 92,
        total: 995,
        average: 85.5,
        grade: 'A'
      },
      {
        khmer: 78,
        math: 82,
        eng: 85,
        his: 75,
        bio: 85,
        geo: 78,
        es: 68,
        mc: 90,
        c: 82,
        p: 85,
        sport: 88,
        ict: 85,
        total: 995,
        average: 85.5,
        grade: 'A'
      },
      {
        khmer: 90,
        math: 88,
        eng: 92,
        his: 80,
        bio: 92,
        geo: 82,
        es: 75,
        mc: 88,
        c: 85,
        p: 90,
        sport: 92,
        ict: 90,
        total: 1004,
        average: 86.9,
        grade: 'A'
      }
    ],
    headers: [
      { title: 'Date', key: 'date' },
      { title: 'Khmer', key: 'khmer' },
      { title: 'Math', key: 'math' },
      { title: 'Eng', key: 'eng' },
      { title: 'His', key: 'his' },
      { title: 'Bio', key: 'bio' },
      { title: 'Geo', key: 'geo' },
      { title: 'Es', key: 'es' },
      { title: 'Mc', key: 'mc' },
      { title: 'C', key: 'c' },
      { title: 'P', key: 'p' },
      { title: 'Sport', key: 'sport' },
      { title: 'ICT', key: 'ict' },
      { title: 'Total', key: 'total' },
      { title: 'Average', key: 'average' },
      { title: 'Grade', key: 'grade' }
    ]
  }),
  created(){
    this.fetchUser()
  },
  computed: {
    ...mapState(useAuthStore,['studentScores','authUser']),
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
    ...mapActions(useAuthStore,['fetchUser']),
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
  }
}
</script>

<template>
  <custom-title icon="mdi-chart-box-plus-outline"></custom-title>
  <v-row>
    <v-col v-for="(exam, index) in uniqueExams" :key="index" cols="4">
      <v-card width="450" :to="`/student-score/${exam.id}/details`">
        <template v-slot:prepend>
          <v-icon size="45" icon="mdi-math-compass"></v-icon>
        </template>
        <template v-slot:title>
          <span class="font-weight-black">{{ exam.exam_name }}</span>
        </template>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import { mapActions, mapState } from 'pinia'
import { useAuthStore } from '@/stores/auth'
export default {
  data: () => ({
    average: 0,
    total: 0,
    loading: false,
    headers: [
      { title: 'Subject Name', key: 'subject_name' },
      { title: 'Score', key: 'score' }
    ]
  }),
  created() {
    this.fetchUser()
  },
  computed: {
    ...mapState(useAuthStore, ['studentScores', 'exams']),
    uniqueExams() {
      const seen = new Set()
      return this.exams.filter(exam => {
        const duplicate = seen.has(exam.exam_name)
        seen.add(exam.exam_name)
        return !duplicate
      })
    }
  },
  methods: {
    ...mapActions(useAuthStore, ['fetchUser']),
  }
}
</script>

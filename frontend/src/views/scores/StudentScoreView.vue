<template>
  <custom-title icon="mdi-chart-box-plus-outline"></custom-title>
  <v-row>
    <v-col v-if="uniqueExams.length == 0">
      <v-alert color="info">{{ $t('exam.noExam') }}</v-alert>
    </v-col>
    <v-col v-for="(exam, index) in uniqueExams" :key="index" cols="4">
      <v-card
        width="450"
        :to="`/student-score/${exam.id}/details`"
        :subtitle="formatDate(exam.created_at)"
        text='ello'
      >
        <template v-slot:prepend>
          <v-btn icon="mdi-math-compass" variant="text"></v-btn>
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
  import { format, parseISO } from 'date-fns'
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
      formatDate(dateString) {
        try {
          const date = parseISO(dateString)
          return format(date, 'dd-MMM-yyyy')
        } catch (error) {
          console.error('Error parsing date:', error)
          return dateString // Fallback to the original string if parsing fails
        }
      }
    }
  }
</script>

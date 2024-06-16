<template>
  <custom-title icon="mdi-chart-box-plus-outline"></custom-title>
  <v-row>
    <v-col v-if="exams.length == 0">
      <v-alert color="info">{{ $t('exam.noExam') }}</v-alert>
    </v-col>
    <v-col v-for="(exam, index) in exams" :key="index" cols="3">
      <v-card width="290" class="card" :subtitle="formatDate(exam.created_at)">
        <template v-slot:title>
          <span class="font-weight-black">{{ exam.exam_name }}</span>
        </template>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            append-icon="mdi-table-eye"
            class="bg-primary text-none"
            variant="text"
            text="See details"
            :to="`/student-score/${exam.id}/details`"
          ></v-btn>
        </v-card-actions>
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
      ...mapState(useAuthStore, ['studentScores', 'exams'])
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
<style scoped>
.card{
  border-right: solid 3px #89474b;
}
</style>
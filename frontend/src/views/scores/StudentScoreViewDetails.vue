<template>
  <custom-title icon="mdi-chart-box-plus-outline"></custom-title>
  <v-data-table-virtual
    :headers="headers"
    :items="studentScores"
    :loading="loading"
    item-value="subject_name"
    class="elevation-1"
    hide-default-footer
    height="500"
    fixed-header
  >
    <template v-slot:item.score="{ value }">
      <v-chip class="bg-primary">
        {{ value }}
      </v-chip>
    </template>
    <template #bottom>
      <v-card class="pa-4">
        <strong>
          Total Score:
          <v-chip>
            <strong>{{ getTotalScore.total }}</strong>
          </v-chip>
        </strong>
        <br />
        <strong>
          Average Score:
          <v-chip :color="getColor(getTotalScore.average)">
            <strong>{{ getTotalScore.average }}</strong>
          </v-chip>
        </strong>
        <br />
        Status :
        <strong :style="{ color: statusColor }">{{ status }}</strong>
      </v-card>
    </template>
  </v-data-table-virtual>
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
      const exam_id = this.$route.params.id
      this.fetchUser({exam:exam_id})
    },
    computed: {
      ...mapState(useAuthStore, ['studentScores']),
      getTotalScore() {
        if (this.studentScores.length === 0) {
          return {
            total: 0,
            average: '0.00'
          }
        }

        const total = this.studentScores.reduce((sum, score) => sum + score.score, 0)
        const average = total / this.studentScores.length

        return {
          total,
          average: average.toFixed(2) // To keep the average to 2 decimal points
        }
      },
      status() {
        const average = parseFloat(this.getTotalScore.average)
        return average < 25 ? 'Fail' : 'Pass'
      },
      statusColor() {
        return this.status === 'Fail' ? 'red' : 'green';
      }
    },
    methods: {
      ...mapActions(useAuthStore, ['fetchUser']),
      getColor(calories) {
        if (calories > 40) return 'green'
        else if (calories > 25 && calories < 40) return 'orange'
        else return 'red'
      }
    }
  }
</script>

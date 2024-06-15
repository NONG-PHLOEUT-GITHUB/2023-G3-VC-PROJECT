<template>
  <custom-title icon="mdi-view-dashboard-edit-outline"></custom-title>
  <v-row class="mb-4">
    <v-col cols="12" md="4">
      <v-card
        class="mx-auto pa-0"
        subtitle="All class 12 in school"
        title="Class 12"
      >
        <template v-slot:prepend>
          <v-avatar color="blue-darken-2">
            <v-icon icon="mdi-math-compass"></v-icon>
          </v-avatar>
        </template>
        <v-card-text class="py-0">
          <v-col>
            <h1>
              <strong>{{ classroom['12'] }}</strong>
            </h1>
          </v-col>
        </v-card-text>
      </v-card>
    </v-col>
    <v-col cols="12" md="4">
      <v-card
        class="mx-auto"
        subtitle="All teachers in school"
        title="Class 11"
      >
        <template v-slot:prepend>
          <v-avatar color="blue-darken-2">
            <v-icon icon="mdi-human-male-board-poll"></v-icon>
          </v-avatar>
        </template>
        <v-card-text class="py-0">
          <v-col>
            <h1>
              <strong>{{ classroom['11'] }}</strong>
            </h1>
          </v-col>
        </v-card-text>
      </v-card>
    </v-col>
    <v-col cols="12" md="4">
      <v-card
        class="mx-auto"
        subtitle="All classrooms in school"
        title="Class 10"
      >
        <template v-slot:prepend>
          <v-avatar color="blue-darken-2">
            <v-icon icon="mdi-google-classroom"></v-icon>
          </v-avatar>
        </template>
        <v-card-text class="py-0">
          <v-col>
            <h1>
              <strong>{{ classroom['10'] }}</strong>
            </h1>
          </v-col>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>

  <StudentMostAbsence></StudentMostAbsence>
</template>

<script>
  import { mapActions, mapState } from 'pinia'
  import { useClassroomStore } from '@/stores/classroom'
  import StudentMostAbsence from '@/components/dashboard/StudentMostAbsence.vue'

  export default {
    components: {
      StudentMostAbsence
    },
    data() {
      return {}
    },
    created() {
      this.getCassroomTotal()
    },
    computed: {
      ...mapState(useClassroomStore, ['classroom'])
    },
    methods: {
      ...mapActions(useClassroomStore, ['getCassroomTotal'])
    }
  }
</script>

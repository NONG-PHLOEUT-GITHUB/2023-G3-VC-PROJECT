<template>
  <custom-title icon="mdi-table-chair"></custom-title>
  <v-card class="" elevation="1">
    <template v-slot:append>
      <v-btn class="me-2">Student list</v-btn>
      <v-btn class="me-2">View Score Report</v-btn>
      <v-btn class="me-2">View attendance Report</v-btn>
      <v-btn icon="mdi-pencil"></v-btn>
    </template>
    <template v-slot:prepend>
      <v-btn icon="mdi-table-chair" variant="text"></v-btn>
      <v-card-title> 12 A </v-card-title>
    </template>

    <v-card-text>
      <v-row>
        <v-col cols="6" md="3" class="py-4">
          <custom-sub-title icon="mdi-sigma">Class coordinator</custom-sub-title>
          <v-card
            v-if="coordinator !== null"
            variant="outlined"
            :title="coordinator.first_name + ' ' + coordinator.last_name"
            :value="item"
            :prepend-avatar="coordinator.profile"
            subtitle="Subject title"
          >
          </v-card>
          <v-alert v-else type="info" variant="outlined">
            There is no coordinator assigned yet.
          </v-alert>
        </v-col>
      </v-row>
      <v-divider></v-divider>
      <custom-sub-title icon="mdi-town-hall">Teacher teaching</custom-sub-title>
      <v-row>
        <v-col v-if="teachers.length !== 0" cols="12" md="3" v-for="(item, i) in teachers" :key="i">
          <v-card
            variant="outlined"
            :title="item.first_name + ' ' + item.last_name"
            :value="item"
            :prepend-avatar="item.profile"
          >
          <v-card-item v-for="subject in item.subjects">
           Subject: <strong>{{ subject.subject_name }}</strong> 
          </v-card-item>
          </v-card>
        </v-col>
        <v-alert v-else type="info" variant="outlined">
          There is no teacher assigned yet.
        </v-alert>
      </v-row>
    </v-card-text>
  </v-card>
</template>
<script>
import { mapActions, mapState } from 'pinia'
import { useClassroomStore } from '@/stores/classroom'
export default {
  data() {
    return {}
  },
  created() {
    const classroomId = this.$route.params.class_id
    this.getClassroomDetails(classroomId)
  },
  computed: {
    ...mapState(useClassroomStore, ['coordinator', 'teachers'])
  },
  methods: {
    ...mapActions(useClassroomStore, ['getClassroomDetails'])
  }
}
</script>

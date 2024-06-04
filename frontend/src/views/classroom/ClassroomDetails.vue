<template>
  <custom-title icon="mdi-table-chair"></custom-title>
  <v-card class="pa-0" elevation="1">
    <template v-slot:append>
      <v-btn
        class="me-2 text-none"
        :to="'/student/' + classroomDetails.id + '/feedback'"
        color="primary"
        append-icon="$vuetify"
        variant="outlined"
        >Students List</v-btn
      >
      <v-btn class="me-2 text-none" color="primary" append-icon="$vuetify" variant="outlined"
        >View Score Report</v-btn
      >
      <v-btn
        class="me-2 text-none"
        :to="`/attendance/` + classroomDetails.id + `/student`"
        color="primary"
        append-icon="$vuetify"
        variant="outlined"
        >View Attendance Report</v-btn
      >
    </template>
    <template v-slot:prepend>
      <v-btn icon="mdi-table-chair" variant="text"></v-btn>
      <v-card-title>
        <v-chip color="primary">
          <strong> {{ classroomDetails.classroom_name }}</strong>
        </v-chip>
      </v-card-title>
    </template>

    <v-card-text class="pa-1">
      <v-row>
        <v-col cols="6" md="6" class="py-4">
          <custom-sub-title icon="mdi-sigma">Class coordinator</custom-sub-title>
          <v-card
            v-if="coordinator !== null"
            :title="coordinator.first_name + ' ' + coordinator.last_name"
            :prepend-avatar="coordinator.profile"
          >
          <v-card-title class="px-2">
              <v-chip-group column>
                <v-chip class="ms-1" variant="outlined" v-for="subject in coordinator.subjects">
                  {{ subject.subject_name }}
                </v-chip>
              </v-chip-group>
            </v-card-title>
          </v-card>
          <v-alert v-else type="info" variant="outlined">
            There is no coordinator assigned yet.
          </v-alert>
        </v-col>
      </v-row>
      <v-divider></v-divider>
      <custom-sub-title icon="mdi-town-hall">Teacher teaching</custom-sub-title>
      <v-row>
        <v-col v-if="teachers.length !== 0" cols="12" md="6" v-for="(item, i) in teachers" :key="i">
          <v-card
            :title="item.first_name + ' ' + item.last_name"
            :value="item"
            :prepend-avatar="item.profile"
          >
            <!-- <span class="ms-3">Teacher Of:</span>  -->
            <v-card-title class="px-2">
              <v-chip-group column>
                <v-chip class="ms-1" variant="outlined" v-for="subject in item.subjects">
                  {{ subject.subject_name }}
                </v-chip>
              </v-chip-group>
            </v-card-title>
          </v-card>
        </v-col>
        <v-alert v-else type="info" variant="outlined"> There is no teacher assigned yet. </v-alert>
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
    ...mapState(useClassroomStore, ['coordinator', 'teachers', 'classroomDetails'])
  },
  methods: {
    ...mapActions(useClassroomStore, ['getClassroomDetails'])
  }
}
</script>

<template>
  <bread-crumb :items="pathTitle" />
  <!-- <v-btn
    size="x-small"
    icon="mdi-arrow-left"
    class="white mr-2"
    @click="goBack"
    variant="tonal"
  ></v-btn>
  <strong class="d-inline-block capitalize-first-letter">
    Classroom Management
  </strong> -->

  <custom-title icon="mdi-table-chair">
    <v-btn
      size="x-small"
      icon="mdi-arrow-left"
      class="white mr-2"
      @click="goBack"
      variant="tonal"
    ></v-btn>
    <strong class="d-inline-block capitalize-first-letter">
      {{ classroomDetails.classroom_name }}
    </strong>
  </custom-title>
  <v-card class="pa-2" elevation="0" variant="outlined">
    <template v-slot:append>
      <v-menu>
        <template v-slot:activator="{ props }">
          <v-btn
            icon="mdi-dots-vertical"
            class="elevation-0"
            v-bind="props"
            color="primary"
          ></v-btn>
        </template>

        <v-list density="compact" nav>
          <v-list-item
            v-for="(item, i) in items"
            :key="i"
            :value="item"
            @click="onMenuClick(item.action, classroomDetails.id)"
          >
            <template v-slot:append>
              <v-icon :icon="item.icon" :color="item.color"></v-icon>
            </template>
            <v-list-item-title v-text="item.title"></v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </template>
    <template v-slot:prepend>
      <!-- <v-btn icon="mdi-table-chair" variant="text"></v-btn> -->
      <v-card-title>
        <strong>Class: {{ classroomDetails.classroom_name }}</strong>
      </v-card-title>
    </template>

    <v-card-text class="pa-1">
      <custom-sub-title icon="mdi-sigma">Class coordinator</custom-sub-title>
      <v-row>
        <v-col cols="6" md="6" class="py-4">
          <v-card
            variant="outlined"
            v-if="coordinator !== null"
            :title="coordinator.first_name + ' ' + coordinator.last_name"
            :prepend-avatar="coordinator.profile"
          >
            <v-card-title class="px-2">
              <v-chip-group column>
                <v-chip
                  class="ms-1"
                  variant="outlined"
                  v-for="subject in coordinator.subjects"
                >
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
      <v-divider class="border-opacity-50 mt-4"></v-divider>
      <custom-sub-title icon="mdi-town-hall">Teacher teaching</custom-sub-title>
      <v-row>
        <v-col
          v-if="teachers.length !== 0"
          cols="12"
          md="6"
          v-for="(item, i) in teachers"
          :key="i"
        >
          <v-card
            :title="item.first_name + ' ' + item.last_name"
            :value="item"
            :prepend-avatar="item.profile"
            variant="outlined"
          >
            <!-- <span class="ms-3">Teacher Of:</span>  -->
            <v-card-title class="px-2">
              <v-chip-group column>
                <v-chip
                  class="ms-1"
                  variant="outlined"
                  v-for="subject in item.subjects"
                >
                  {{ subject.subject_name }}
                </v-chip>
              </v-chip-group>
            </v-card-title>
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
      ...mapState(useClassroomStore, [
        'coordinator',
        'teachers',
        'classroomDetails'
      ]),
      pathTitle() {
        return [
          {
            title: this.pageTitle,
            to: { name: 'Class Management' },
            exact: true
          },
          {
            title: this.pageSubTitle
          }
        ]
      },
      pageTitle() {
        return `Class Management`
      },
      pageSubTitle() {
        return  'Class Management description'
      },
      items() {
        return [
          {
            action: 'studentList',
            title: this.$t('btn.studentList'),
            icon: 'mdi-list-box-outline',
            color: 'primary'
          },
          {
            action: 'checkAttendance',
            title: this.$t('btn.checkAtt'),
            icon: 'mdi-check-decagram-outline',
            color: 'primary'
          },
          {
            action: 'scoreReport',
            title: this.$t('btn.scoreReport'),
            icon: 'mdi-chart-timeline',
            color: 'primary'
          },
          {
            action: 'aReport',
            title: this.$t('btn.attReport'),
            icon: 'mdi-chart-multiline',
            color: 'primary'
          }
        ]
      }
    },
    methods: {
      ...mapActions(useClassroomStore, ['getClassroomDetails']),
      onMenuClick(action, id) {
        switch (action) {
          case 'studentList':
            this.$router.push(`/student/${id}/feedback`)
            break
          case 'checkAttendance':
            this.$router.push(`/attendance/${id}/student`)
            break
          case 'scoreReport':
            this.$router.push(`/attendance/${id}/student`)
            break
          case 'aReport':
            this.$router.push(`/attendance-report/${id}/by-class`)
            break
          default:
            break
        }
      },
      goBack() {
        this.$router.back()
      }
    }
  }
</script>

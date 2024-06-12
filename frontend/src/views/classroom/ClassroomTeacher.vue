<template>
  <custom-title icon="mdi-google-classroom">
    <template #right>
      <v-btn
        variant="outlined"
        append-icon="mdi-filter-multiple-outline"
        class="text-none"
        color="primary"
        @click="toggleFilter = !toggleFilter"
      >
        {{ $t('btn.filter') }}
      </v-btn>
    </template>
  </custom-title>
  <v-slide-y-reverse-transition mode="in-out">
    <classroom-filter v-show="toggleFilter" @filter-applied="onFilterApplied" />
  </v-slide-y-reverse-transition>
  <div class="main">
    <custom-sub-title icon="mdi-account-tie-woman">
      {{ $t('classroom.coordinator') }}
    </custom-sub-title>
    <v-row dense>
      <v-col cols="12" md="3">
        <v-card
          v-if="coordinator !== null"
          prepend-icon="mdi-chair-school"
          variant="outlined"
        >
          <template v-slot:title>
            <span class="font-weight-black">
              Class: {{ coordinator.classroom_name }}
            </span>
          </template>
          <v-card-text>
            Totl student: {{ coordinator.student_count }}
          </v-card-text>
          <template v-slot:append>
            <v-menu>
              <template v-slot:activator="{ props }">
                <v-btn
                  icon="mdi-dots-vertical"
                  class="elevation-0"
                  v-bind="props"
                ></v-btn>
              </template>

              <v-list density="compact">
                <v-list-item
                  v-for="(item, i) in items"
                  :key="i"
                  :value="item"
                  @click="onMenuClick(item.action, coordinator.id)"
                >
                  <template v-slot:prepend>
                    <v-icon :icon="item.icon" :color="item.color"></v-icon>
                  </template>
                  <v-list-item-title v-text="item.title"></v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>
          </template>
        </v-card>
        <v-alert
          v-else
          text="No class coordinator assigned yet."
          type="info"
        ></v-alert>
      </v-col>
    </v-row>
    <custom-sub-title icon="mdi-account-tie" class="mt-2">
      {{ $t('classroom.cteaching') }}
    </custom-sub-title>
    <v-row dense>
      <v-col
        v-if="teacherTeachingClass.length !== 0"
        cols="12"
        md="3"
        v-for="classroom in teacherTeachingClass"
      >
        <v-card prepend-icon="mdi-chair-school" color="primary">
          <template v-slot:title>
            <span class="font-weight-black">
              Class: {{ classroom.classroom_name }}
            </span>
          </template>
          <v-card-text>Totl student: {{ classroom.student_count }}</v-card-text>
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

              <v-list density="compact">
                <v-list-item
                  v-for="(item, i) in items"
                  :key="i"
                  :value="item"
                  @click="onMenuClick(item.action, classroom.id)"
                >
                  <template v-slot:prepend>
                    <v-icon :icon="item.icon" :color="item.color"></v-icon>
                  </template>
                  <v-list-item-title v-text="item.title"></v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>
          </template>
        </v-card>
      </v-col>
      <v-alert
        v-else
        text="No class teaching assigned yet."
        type="info"
      ></v-alert>
    </v-row>
  </div>
</template>

<script>
  import { mapActions, mapState } from 'pinia'
  import { useTeacherStore } from '@/stores/teacher'
  import ClassroomFilter from '@/components/filters/ClassroomFilter.vue'
  export default {
    components: {
      ClassroomFilter
    },
    data() {
      return { filterCriteria: {}, toggleFilter: false }
    },
    created() {
      this.getTeacherClassTeaching(this.filterCriteria)
    },
    computed: {
      ...mapState(useTeacherStore, ['teacherTeachingClass', 'coordinator']),
      items() {
        return [
          {
            action: 'studentList',
            title: this.$t('btn.studentList'),
            icon: 'mdi-list-box-outline'
          },
          {
            action: 'checkAttendance',
            title: this.$t('btn.checkAtt'),
            icon: 'mdi-check-decagram-outline'
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
      ...mapActions(useTeacherStore, ['getTeacherClassTeaching']),
      storeClassroomIdAndNavigate(classroomId) {
        // Store classroom.id in local storage
        localStorage.setItem('classroomId', classroomId)

        // Navigate to the desired URL
        this.$router.push(`/student/${classroomId}/feedback`)
      },
      onMenuClick(action, id) {
        switch (action) {
          case 'studentList':
            this.storeClassroomIdAndNavigate(id)
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
      onFilterApplied(filterText) {
        this.filterCriteria = filterText
        this.getTeacherClassTeaching(this.filterCriteria)
      }
    }
  }
</script>

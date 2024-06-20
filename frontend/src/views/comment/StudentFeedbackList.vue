<template>
  <custom-title icon="mdi-eye-check-outline">
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
    <filter-student-each-class v-show="toggleFilter" @filter-student="onFilterApplied" />
  </v-slide-y-reverse-transition>
  <v-data-table
    :headers="headers"
    :items="studentInClassroom"
    :loading="loading"
    item-value="name"
    class="elevation-0"
  >
    <template v-slot:item.profile="{ item }">
      <v-avatar size="large">
        <v-img :src="item.profile" alt="Avatar" cover></v-img>
      </v-avatar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-btn
        :to="'/feedback/' + item.id + '/student'"
        variant="text"
        icon="mdi-message-processing-outline"
      ></v-btn>
    </template>
  </v-data-table>
</template>

<script>
  import { mapActions, mapState } from 'pinia'
  import { useClassroomStore } from '@/stores/classroom'
  import FilterStudentEachClass from '@/components/filters/FilterStudentEachClass.vue'
  export default {
    components: { FilterStudentEachClass },
    data() {
      return {
        students: [],
        date: null,
        chat_id: null,
        classrooms: [],
        itemsPerPage: 10,
        loading: false,
        toggleFilter: false,
        filterCriteria: {},
        headers: [
          { title: 'Profile', key: 'profile' },
          { title: 'First Name', key: 'first_name' },
          { title: 'Last Name', key: 'last_name' },
          { title: 'Gender', key: 'gender' },
          { title: 'Email', key: 'email' },
          { title: '', key: 'actions' }
        ]
      }
    },
    created() {
      const id = this.$route.params.classroomId
      this.getStudentsInClassroom({ classroomId: id, ...this.filterCriteria })
    },
    computed: {
      ...mapState(useClassroomStore, ['studentInClassroom']),
    },
    methods: {
      ...mapActions(useClassroomStore, ['getStudentsInClassroom']),
      onFilterApplied(filterData) {
        this.filterCriteria = filterData
        const id = this.$route.params.classroomId;
        this.getStudentsInClassroom({ classroomId: id, ...filterData })
      }
    }
  }
</script>

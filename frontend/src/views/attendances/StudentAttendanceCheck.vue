<template>
   <v-btn
    size="x-small"
    icon="mdi-arrow-left"
    class="white mr-2"
    @click="goBack"
    variant="tonal"
  ></v-btn>
  <strong class="d-inline-block capitalize-first-letter">
    Classroom Details
  </strong>
  <custom-title icon="mdi-book-check-outline">
    <template #right>
      <v-date-input
        :allowed-dates="allowedDates"
        prepend-icon=""
        prepend-inner-icon="$calendar"
        variant="outlined"
        v-model="checkDate"
        :rules="[() => !!checkDate || 'This field is required']"
        hide-actions
        density="compact"
        hide-details
        width="250px"
      ></v-date-input>
      <v-btn
        variant="outlined"
        append-icon="mdi-filter-multiple-outline"
        class="text-none me-4 ms-4"
        color="primary"
        @click="toggleFilter = !toggleFilter"
      >
        {{ $t('btn.filter') }}
      </v-btn>
      <v-btn
        variant="tonal"
        class="me-2 bg-green-darken-1 text-none"
        @click="createAttendance()"
        append-icon="mdi-send-circle"
      >{{ $t('btn.save') }}</v-btn>
    </template>
  </custom-title>
  <v-slide-y-reverse-transition mode="in-out">
    <filter-student-each-class
      v-show="toggleFilter"
      @filter-student="onFilterApplied"
    />
  </v-slide-y-reverse-transition>
  <v-data-table
    v-model="selectedValues"
    :headers="headers"
    :items="studentInClassroom"
    item-value="id"
    class="elevation-0"
  >
    <template v-slot:body="{ items }">
      <tr
        v-for="item in items"
        :key="item.id"
        :class="{ 'bg-selected': !item.selected, 'bg-primary': item.selected }"
      >
        <td>
          <v-switch
            @update:modelValue="getSelected(item)"
            inset
            v-model="item.selected"
            color="red"
            false-icon="mdi-plus"
            true-icon="mdi-check"
            hide-details
          ></v-switch>
        </td>
        <td>
          <v-avatar size="large">
            <v-img :src="item.profile" alt="Avatar" cover></v-img>
          </v-avatar>
        </td>
        <td>{{ item.first_name }}</td>
        <td>{{ item.last_name }}</td>
        <td>{{ item.gender }}</td>
        <td>{{ item.email }}</td>
        <td>
          <v-select
            :items="statusOptions"
            variant="outlined"
            item-title="label"
            item-value="value"
            v-model="item.status"
            density="compact"
            hide-details
          ></v-select>
        </td>
        <td>
          <v-textarea
            density="compact"
            rows="1"
            variant="outlined"
            v-model="item.reason"
            hide-details
          ></v-textarea>
        </td>
      </tr>
    </template>
  </v-data-table>
</template>

<script>
  import { mapActions, mapState } from 'pinia'
  import { useClassroomStore } from '@/stores/classroom'
  import { useAttendanceStore } from '@/stores/attendance'
  import FilterStudentEachClass from '@/components/filters/FilterStudentEachClass.vue'
  import axios from 'axios'
  import { format } from 'date-fns'
  export default {
    components: { FilterStudentEachClass },
    data() {
      return {
        selectedValues: [],
        toggleFilter: false,
        checkDate: new Date(),
        filterCriteria: {},
        reason: '',
        status: '',
        headers: [
          { title: 'Select', key: 'select', sortable: false, width: '0%' },
          { title: 'Profile', key: 'profile', sortable: false },
          { title: 'First Name', key: 'first_name', width: '12%' },
          { title: 'Last Name', key: 'last_name', width: '12%' },
          { title: 'Gender', key: 'gender', sortable: false },
          { title: 'Email', key: 'email' },
          { title: 'Status', key: 'status', width: '15%', sortable: false },
          { title: 'Reason', key: 'reason', width: '15%', sortable: false }
        ],
        statusOptions: [
          { value: 'Present', label: 'Present' },
          { value: 'Absent', label: 'Absent' },
          { value: 'Early', label: 'Early' },
          { value: 'Excused', label: 'Excused' },
          { value: 'Unexcused', label: 'Unexcused' },
          { value: 'On leave', label: 'On leave' },
          { value: 'No show', label: 'No show' }
        ]
      }
    },
    created() {
      const id = this.$route.params.classroomId
      this.getStudentsInClassroom({ classroomId: id, ...this.filterCriteria })
    },
    computed: {
      ...mapState(useClassroomStore, ['studentInClassroom']),
      formattedDate() {
        // Use the format function to format the date
        // return format(this.checkDate, 'yyyy-MM-dd')
        if (
          !(this.checkDate instanceof Date) ||
          isNaN(this.checkDate.getTime())
        ) {
          return '' // Return an empty string or another default value if this.checkDate is not valid
        }
        // Use the format function to format the date
        return format(this.checkDate, 'yyyy-MM-dd')
      }
    },
    methods: {
      ...mapActions(useClassroomStore, ['getStudentsInClassroom']),
      ...mapActions(useAttendanceStore, ['checkAttendance']),
      goBack() {
        this.$router.back()
      },
      allowedDates(date) {
        const today = new Date()
        today.setHours(0, 0, 0, 0) // Ensure comparison is only by date, not time
        const selectedDate = new Date(date)
        selectedDate.setHours(0, 0, 0, 0) // Ensure comparison is only by date, not time
        return selectedDate <= today
      },
      getSelected(item) {
        this.selectedValues.push(item)
      },
      createAttendance() {
        if (!this.formattedDate || isNaN(new Date(this.formattedDate))) {
          this.$root.$notif('Please select a date', {
            type: 'warning',
            color: 'yellow'
          })
          return // Exit the function early if the date is empty
        }

        // Define an array to store promises
        const promises = []

        this.selectedValues.forEach(selected => {
          const formData = {
            status: selected.status || '', // Default to 'undefined' if status is not provided
            reason: selected.reason || '', // Default to 'undefined' if reason is not provided
            date: this.formattedDate,
            user_id: selected.id
          }
          promises.push(
            this.checkAttendance(formData)
              .then(() => {
                const message = `Student name: ${selected.first_name} ${selected.last_name}\nGender: ${selected.gender}\nStatus: ${selected.status}\nReason: ${selected.reason}\nAbsent date: ${this.formattedDate}`

                axios.post(process.env.VUE_APP_TELEGRAM_BASE_TOKEN, {
                  chat_id: selected.parent_chat_id, // Use parent_chat_id for the Telegram message
                  text: message
                })
              })
              .catch(err => {
                this.$root.$notif(err, {
                  type: 'error',
                  color: 'red'
                })
                throw err
              })
          )
        })
        // Wait for all promises to resolve
        Promise.all(promises)
          .then(() => {
            this.$root.$notif(this.$t('alert.create'), {
              type: 'success',
              color: 'primary'
            })
            this.selectedValues = []
          })
          .catch(err => {
            console.error('Error creating attendance:', err)
          })
      },
      onFilterApplied(filterData) {
        this.filterCriteria = filterData
        const id = this.$route.params.classroomId
        this.getStudentsInClassroom({ classroomId: id, ...filterData })
      }
    }
  }
</script>

<style scoped>
  ::v-deep .v-data-table > .v-data-table__wrapper > table > tbody > tr > td {
    padding-top: 25px;
  }
</style>

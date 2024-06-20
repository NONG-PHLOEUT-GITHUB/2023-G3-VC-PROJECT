<template>
  <v-form @submit.prevent="applyFilter" class="mb-4">
    <v-card class="py-4 px-3 elevation-0">
      <v-row>
        <v-col cols="12" md="4" lg="4">
          <v-text-field
            hide-details
            density="compact"
            variant="outlined"
            label="Exam Name"
            v-model="exam_name"
            @keyup="applyFilter"
            color="textField"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="4" lg="4">
          <v-text-field
            hide-details
            density="compact"
            variant="outlined"
            label="Exam Code"
            v-model="exam_code"
            @keyup="applyFilter"
            color="textField"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="4" lg="4">
          <v-text-field
            hide-details
            density="compact"
            variant="outlined"
            label="Subject Name"
            v-model="subject_name"
            @keyup="applyFilter"
            color="textField"
          ></v-text-field>
        </v-col>
      </v-row>
    </v-card>
  </v-form>
</template>

<script>
  export default {
    data() {
      return {
        exam_name: '',
        exam_code: '',
        subject_name: ''
      }
    },
    methods: {
      applyFilter() {
        const filterData = {
          exam_name: this.exam_name,
          exam_code: this.exam_code,
          subject_name: this.subject_name
        }
        this.$emit('filter-exam', filterData)
      }
    }
  }
</script>

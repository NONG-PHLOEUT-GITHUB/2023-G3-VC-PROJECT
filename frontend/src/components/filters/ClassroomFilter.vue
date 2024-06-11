<template>
  <v-form class="mb-4">
    <v-card class="py-4 px-3">
      <v-row>
        <v-col>
          <v-text-field
            v-model="className"
            hide-details
            density="compact"
            variant="outlined"
            label="Classroom name"
            @keyup="applyFilter"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            @keyup="applyFilter"
            v-model="coordinatorName"
            hide-details
            density="compact"
            variant="outlined"
            label="Coordinator name"
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
        className: '',
        coordinatorName: '',
        className: ''
      }
    },
    methods: {
      applyFilter() {
        const filterData = {
          className: this.className,
          coordinatorName: this.coordinatorName,
        }
        this.$emit('filter-applied', filterData)
      }
    }
  }
</script>

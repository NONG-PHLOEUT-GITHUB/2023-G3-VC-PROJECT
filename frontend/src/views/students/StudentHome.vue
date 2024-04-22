<template>
  <custom-title icon="mdi-view-dashboard-outline"></custom-title>
  <student-graph></student-graph>
</template>
<script>
import StudentGraph from "@/components/dashboard/StudentGraph.vue";

export default {
  components: {
    StudentGraph,
  },
};
</script>

<style scoped>

</style>

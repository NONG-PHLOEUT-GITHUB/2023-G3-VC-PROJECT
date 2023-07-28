<template>
  <student-dashboard />
  <v-sheet
    class="sheet d-flex align-center justify-center flex-wrap text-center px-4"
    elevation="4"
    height="250"
    rounded
    max-width="80%"
  >
    <div>
      <h2 class="text-h4 font-weight-black text-orange">
        Welcome to our system!
      </h2>
      <div class="text-h5 font-weight-medium mb-2">
        You are officially a part of the Vuetify Community!
      </div>

      <p class="text-body-2 mb-4">
        Please head over to your inbox/spam or others folder to find our
        verificaiton email.
      </p>
      <v-btn variant="text" color="orange">Go to Login</v-btn>
    </div>
  </v-sheet>
  <student-graph></student-graph>
</template>
<script>
import StudentGraph from "./StudentGraph.vue";

export default {
  components: {
    StudentGraph,
  },
};
</script>

<style scoped>
@import "~vuetify/dist/vuetify.css";

.sheet {
  margin-top: 10px;
  margin-left: 19%;
}
</style>

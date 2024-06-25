<template>
  <v-layout>
    <app-bar />
    <v-main>
      <v-container class="px-0" fluid>
        <router-view />
      </v-container>
    </v-main>
  </v-layout>
</template>
<script>
import AppBar from "../nav/NavBar.vue";

export default {
  name: "Layout",
  components: {
    AppBar,
  },
  methods: {},
};
</script>

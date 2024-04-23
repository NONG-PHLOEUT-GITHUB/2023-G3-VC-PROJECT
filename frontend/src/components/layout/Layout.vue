<template>
  <v-layout class="rounded rounded-md">
    <sidebar v-model="drawer" />
    <app-bar @toggle="toggleNav" />
    <v-main class="main">
      <v-container class="px-4" fluid>
        <router-view />
      </v-container>
    </v-main>
  </v-layout>
</template>
<script>
import Sidebar from './Sidebar.vue'
import AppBar from './AppBar.vue'

export default {
  props: ['menubar'],
  name: 'LayoutDashboard',

  components: {
    Sidebar,
    AppBar
  },
  data: () => ({
    drawer: true
  }),

  methods: {
    toggleNav() {
      this.drawer = !this.drawer
    }
  }
}
</script>

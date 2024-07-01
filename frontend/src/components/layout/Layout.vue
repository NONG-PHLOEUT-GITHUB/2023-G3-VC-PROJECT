<template>
  <!-- <v-layout class="rounded rounded-md"> -->
  <sidebar v-model="drawer" @resize="resizeWidth" />
  <app-bar @toggle="toggleNav" :width="appBarWidth"/>
  <v-main class="main">
    <v-container class="px-4 bg-background" fluid>
      <router-view />
    </v-container>
  </v-main>
  <!-- </v-layout> -->
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
      drawer: true,
      appBarWidth: '100%',
    }),

    methods: {
      toggleNav() {
        this.drawer = !this.drawer
      },
      resizeWidth(width) {
        this.appBarWidth = width
        this.$vuetify.application.left = width.slice(0, -2)
        this.$refs.vMain.$el.style.userSelect = 'none'
      }
    }
  }
</script>

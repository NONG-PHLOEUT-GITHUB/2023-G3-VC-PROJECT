<template>
  <Notif ref="notif" dismissible :default-timeout="7000" />
  <Loading />
  <router-view />
</template>

<script>
import Notif from '@/components/global/Notification.vue'
import Loading from '@/components/global/Loading.vue'
export default {
  name: 'App',
  components: {
    Notif,
    Loading
  },
  mounted() {
    this.$root.$notif = this.$refs.notif.newAlert
  }
}
</script>

<style>
html {
  overflow-y: auto;
}
#app {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  font-family: 'Poppins', sans-serif;
}

</style>

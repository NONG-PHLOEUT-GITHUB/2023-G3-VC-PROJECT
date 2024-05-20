<template>
  <Notif ref="notif" dismissible :default-timeout="2000" />
  <Confirm ref="confirm" />
  <Loading />
  <router-view />
</template>

<script>
import Notif from '@/components/global/Notification.vue'
import Confirm from '@/components/global/Confirm.vue'
import Loading from '@/components/global/Loading.vue'
export default {
  name: 'App',
  components: {
    Notif,
    Confirm,
    Loading
  },
  mounted() {
    this.$root.$confirm = this.$refs.confirm.open
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

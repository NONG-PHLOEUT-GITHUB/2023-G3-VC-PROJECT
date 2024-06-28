<template>
  <v-app>
    <token-expired />
    <Notif ref="notif" dismissible :default-timeout="2000" />
    <Confirm ref="confirm" />
    <router-view />
    <Loading />
  </v-app>
</template>

<script>
  import Notif from '@/components/global/Notification.vue'
  import Confirm from '@/components/global/Confirm.vue'
  import Loading from '@/components/global/Loading.vue'
  import TokenExpired from '@/components/common/TokenExpired.vue';
  export default {
    name: 'App',
    components: {
      Notif,
      Confirm,
      Loading,
      TokenExpired
    },
    methods: {
      handleKeyDown(e) {
        if (e.shiftKey && e.ctrlKey && e.key === 'L') {
          e.preventDefault() // Prevent any default behavior
          this.$i18n.locale = this.$i18n.locale === 'en' ? 'kh' : 'en'
          localStorage.setItem('lang', this.$i18n.locale)
        }
      }
    },
    mounted() {
      this.$root.$confirm = this.$refs.confirm.open
      this.$root.$notif = this.$refs.notif.newAlert
      
      const savedLang = localStorage.getItem('lang')
      if (savedLang) {
        this.$i18n.locale = savedLang
      }
      document.addEventListener('keydown', this.handleKeyDown)
    },
    beforeDestroy() {
      // Clean up the event listener when the component is destroyed
      document.removeEventListener('keydown', this.handleKeyDown)
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
  thead tr th {
    font-size: 15px;
    font-weight: bold;
    /* background: red; */
  }
</style>

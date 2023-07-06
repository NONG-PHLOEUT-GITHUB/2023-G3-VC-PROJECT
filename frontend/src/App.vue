<template>
  <div clas="h-screen flex-grow-1 overflow-y-lg-auto">
    <main>
      <dashboard-view>
        <router-view></router-view>
      </dashboard-view>
    </main>
  </div>
</template>

<script>
import DashboardView from './components/Navigation/DashboardView.vue';

export default {
  components: {
    DashboardView,
  },

  data: () => ({
    //
  }),
}
</script>

<style>
@import url(https://unpkg.com/@webpixels/css@1.1.5/dist/index.css);

/* Bootstrap Icons */
@import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");
</style>

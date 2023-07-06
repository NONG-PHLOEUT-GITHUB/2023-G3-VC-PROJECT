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
<<<<<<< HEAD
import DashboardView from './components/Navigation/DashboardView.vue';

export default {
  components: {
    DashboardView,
  },
=======

export default {
>>>>>>> b97def07089cd5d70142388c11392bc06fcc240b

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

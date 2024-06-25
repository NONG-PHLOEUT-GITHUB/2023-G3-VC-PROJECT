<template>
  <v-card
    class="d-flex justify-space-between main-card py-1 px-1 elevation-0 md-1 rounded-0"
    border="primary b-sm opacity-100"
  >
    <div class="header-title-wrapper d-flex align-center">
      <h3 class="d-flex align-center">
        <v-icon class="ml-6" color="amber-accent-3" v-if="icon" size="45">
          {{ icon }}
        </v-icon>
        <v-card-title class="title pr-1">{{ title !== '' ? title : currentRouteName }}</v-card-title>
        <slot />
      </h3>
    </div>
    <div class="d-flex align-center">
      <slot name="right"> </slot>
    </div>
  </v-card>
</template>

<script>
export default {
  name: "CustomTitle",
  props: {
    icon: { type: String, required: false },
    title: { type: String, required: false, default: ''}
  },
  computed:{
    currentRouteName() {
      return this.$route.name;
    }
  },
};
</script>

<style scoped>
.header-title-wrapper {
  width: 100%;
}
.main-card {
  background-color: var(--v-bg-light-blue);
}
.title {
  text-transform: uppercase;
  font-weight: bold;
  color: var(--t-color-blue);
}
</style>

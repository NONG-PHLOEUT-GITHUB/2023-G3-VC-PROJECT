<template>
  <v-card class="d-flex justify-space-between py-2 px-3 elevation-0 mb-3">
    <div
      class="header-title-wrapper d-flex align-center"
    >
      <h4 class="d-flex align-center">
        <v-icon class="mr-2" v-if="icon">
          {{ icon }}
        </v-icon>
        {{ $route.name }}
        <slot />
      </h4>
    </div>
    <div class="d-flex align-center">
      <slot name="right">
        <v-btn v-if="rightIcon">
          <v-icon>
            {{ rightIcon }}
          </v-icon>
        </v-btn>
      </slot>
    </div>
  </v-card>
</template>

<script>
export default {
  name: "CustomTitle",
  props: {
    icon: { type: String, required: false },
    rightIcon: { type: String },
  },
};
</script>

<style scoped>
.header-title-wrapper {
  width: 100%;
}
</style>

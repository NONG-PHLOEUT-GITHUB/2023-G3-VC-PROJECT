<template>
  <v-row
    v-if="isLoading && !forceStopLoading"
    class="overlay text-center"
    align="center"
    no-gutters
  >
    <v-col>
      <div class="text-subtitle-2 font-weight-medium text-uppercase">
        {{ message }}
      </div>
      <v-progress-circular color="primary" size="90" width="6" class="my-4" :indeterminate="true" />
    </v-col>
  </v-row>
</template>

<script>
import { mapState } from 'pinia'
import { useLoadingStore } from '@/stores/loading'
export default {
  name: 'CommonOverlay',
  computed: {
    ...mapState(useLoadingStore, ['isLoading', 'forceStopLoading', 'message'])
  }
}
</script>

<style scoped>
.overlay {
  position: fixed;
  z-index: 999;
  width: 100%;
  height: 100%;
  background: rgba(250, 250, 250, 0.5);
  top: 0;
  left: 0;
}
</style>

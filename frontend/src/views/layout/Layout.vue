<template>
  <layout />
  <!-- Design your layout -->
</template>
<script>
  import Layout from '@/components/layout/Layout.vue'

  export default {
    components: {
      Layout
    }
  }
</script>
<style>
  .bg-violet {
    background-color: var(--v-bg-violet);
    color: var(--v-color-white);
  }
  .v-container .v-container--fluid {
    padding-left: 2%;
    padding-right: 2%;
  }
  .fontSizeTable {
    font-size: 12px;
  }
  .icon-color {
    color: var(--t-color-blue);
  }
  .bg-blue {
    background-color: var(--v-bg-violet);
    color: var(--v-color-white);
  }
  .color-error {
    color: var(--v-bg-error);
  }
  .comfirm {
    background-color: var(--v-bg-blue);
    color: var(--v-color-white);
  }
  .enregistrer {
    background-color: var(--v-bg-blue);
    color: var(--v-color-white);
  }
  .annuler {
    color: #9a0303;
    /* font-size: 12px; */
  }
  .nouveau {
    background-color: var(--v-bg-blue);
    /* font-size: 12px; */
    color: var(--v-color-white);
  }
  .importerXls {
    background-color: var(--v-bg-blue);
    /* font-size: 12px; */
    color: var(--v-color-white);
  }
  .bg-dialog {
    background-color: var(--v-bg-light-blue);
  }
  .blue-text {
    color: var(--t-color-blue);
  }
</style>

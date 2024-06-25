<template>
  <v-autocomplete
    v-model="selectedItems"
    :color="color"
    :items="items"
    :label="label"
    :item-value="itemValue"
    :item-title="itemTitle"
    :multiple="multiple"
    :clearable="clearable"
    :density="density"
    class="customselect"
    ref="select"
    variant="outlined"
    hide-details
    density="compact"
    @change="onChange()"
  >
  </v-autocomplete>
</template>

<script>
export default {
  props: {
    items: {
      type: Array,
      required: true,
    },
    label: {
      type: String,
      required: false,
      default: ""
    },
    itemValue: {
      type: String,
      required: true,
    },
    itemTitle: {
      type: String,
      required: true,
    },
    multiple: {
      required: false,
      type: Boolean,
      default: false,
    },
    color: {
      required: false,
      type: String,
      default: "primary",
    },
    disabled: {
      type: Boolean,
      required: false,
      default: false,
    },
    clearable: {
      type: Boolean,
      required: false,
      default: false,
    },
    search: {
      type: Boolean,
      required: false,
      default: false,
    },
    density: {
      type: String,
      required: false,
      default: 'compact'
    },
  },
  data() {
    return {
      selectedItems: [],
    };
  },
  computed: {
    get() {
      return this.items;
    },
  },
  watch: {
    value(val) {
      if (!val) return;
      this.selectedItems = val;
    },
  },
  methods: {
    onChange() {
      this.$emit("input", this.selectedItems);
    },
  },
};
</script>

<style>
  .customselect.v-autocomplete{
    margin-top: -4px;
  }
  .customselect.v-autocomplete .v-field--appended {
    background-color: rgb(41, 40, 40);
  }
  .customselect.v-autocomplete .v-icon {
    color: white;
    opacity: 1;
    align-items: center;
  }

  .customselect.v-autocomplete .v-icon.mdi-menu-down::before {
    content: "\F0140"
  }

  .customselect.v-autocomplete .v-field {
    padding-right: 6px;
  }

  .customselect.v-autocomplete .v-field__field {
    background-color: white !important;
  }
  .customselect.v-autocomplete.v-input--density-compact .v-field__input {
    padding-top: 2px;
    padding-bottom: 2px;
    min-height: 30px;
  }
</style>

import { defineStore } from 'pinia';

export const useCommonStore = defineStore('common', {
  state: () => ({
    isTokenExpired: false,
  }),
  actions: {
    setTokenExpired(status) {
      this.isTokenExpired = status;
    },
  },
});

import { defineStore } from "pinia";
import {
  checkPeriodIsValid,
  fetchCalendrier
} from "../api/calendrier";

export const useCalendrierStore = defineStore("calendrier", {
  state: () => ({
    calendriers: [],
  }),
  actions: {
    async getCalendrier() {
      const response = await fetchCalendrier();
      this.calendriers=response.data;
    },
    async checkPeriodIsValid(period) {
      const response = await checkPeriodIsValid(period);
      return response;
    },
  },
});

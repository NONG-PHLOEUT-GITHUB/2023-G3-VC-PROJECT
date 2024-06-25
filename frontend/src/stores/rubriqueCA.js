import { defineStore } from "pinia";
import { getAllRubriqueCa } from "../api/rubriqueCA";

export const useRubriqueCAStore = defineStore("rubriqueCA", {
  state: () => ({
    rubriquesCa: [],
  }),
  actions: {
    async getAllRubriqueCa() {
      const response = await getAllRubriqueCa();
      this.rubriquesCa = response.data;
      return response;
    },
  },
});

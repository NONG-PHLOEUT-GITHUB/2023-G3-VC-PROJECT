import { defineStore } from "pinia";
import { getAllRubriquePrestation } from "../api/rubriquePrestation";

export const useRubriquePrestaStore = defineStore("rubriquePresta", {
  state: () => ({
    rubriquesPresta: [],
  }),
  actions: {
    async getAllRubriquePrestation() {
      const response = await getAllRubriquePrestation();
      this.rubriquesPresta = response.data;
      return response;
    },
  },
});

import { defineStore } from "pinia";
import { 
  addJustificatif,
  deleteJustificatif,
  getJustificatifByEnteteId,
  printJustificatif
 } from "../api/prestationJustif";

export const usePrestaionJustifStore = defineStore("prestaionJustif", {
  state: () => ({
    prestaJustifs: [],
    selectedJustifFiles: []
  }),
  actions: {
    async getJustificatif(prestaEnteteId) {
      const response = await getJustificatifByEnteteId(prestaEnteteId);
      this.prestaJustifs = response.data;
      return response;
    },
    async deleteJustificatif(justifId) {
      const response = await deleteJustificatif(justifId);
      return response;
    },
    async addJustificatif(params) {
      const response = await addJustificatif(params);
      return response;
    },
    async printJustificatif(justifId) {
      const response = await printJustificatif(justifId);
      return response;
    }
  },
});

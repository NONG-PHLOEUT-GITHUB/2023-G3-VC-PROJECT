import { defineStore } from 'pinia'
import {
  fetchVisualisation,
  fetchServiceLigne,
  fetchDeleteVisualisation,
  getPrestationById,
  setPrestationLignes,
  deletePrestationLigne,
  fetchSetPrestation,
  fetchExcelFile,
  getProforma
} from '../api/prestation'
import { getClientSites } from '../api/site'
import { getAllRubriqueCa } from '../api/rubriqueCA'

export const usePrestationStore = defineStore('visualisation', {
  state: () => ({
    visualLists: [],
    lignes: [],
    prestation: {},
    selectedCalendrier: null,
    itemsExcel: {},
    prestaLignes: [],
    autrePrestaLignes: [],
    sites: [],
    rubriquesCA: {},
    proformaCode: ''
  }),
  actions: {
    async getVisualisation(data) {
      const response = await fetchVisualisation(data)
      this.visualLists = response.data
    },
    async getServiceLigne() {
      const response = await fetchServiceLigne()
      this.lignes = response.data
    },
    async getPrestationById(enteteId) {
      const response = await getPrestationById(enteteId)
      this.prestation = response.data
      return response
    },
    async setPrestationLignes(data) {
      const response = await setPrestationLignes(data)
      return response
    },
    async deleteVisualisation(id) {
      return await fetchDeleteVisualisation(id)
    },
    async setPrestation(data) {
      return await fetchSetPrestation(data)
    },

    async deletePrestationLigne(prestaLigneId) {
      const response = await deletePrestationLigne(prestaLigneId)
      return response
    },
    async setSelectedCalendrier(period) {
      this.selectedCalendrier = period
    },
    async getRubriqueCaById(item) {
      const rubriqueCa = await getAllRubriqueCa()
      return rubriqueCa.data.find(ca => ca.value === item)
    },
    async uploadExcelFile(data) {
      this.itemsExcel = null
      const response = await fetchExcelFile(data)
      const res = await getClientSites()
      const info = response.data.GENERALINFO

      const site = res.data
      const siteCode = site.find(
        item => item.siteLabel === info.clientName
      )?.siteCode

      const lignes = response.data.LINES
      const generalInfo = {
        presta_fact_contact_nom: info.contactName,
        hour: info.hour,
        presta_fact_numero_commande: info.commandNumber,
        presta_floor: info.floor,
        presta_fact_code_imputation: info.imputationCode,
        presta_room_nom: info.roomName,
        presta_delivery_time: info.deliveryTime,
        presta_fact_bu: info.bu,
        presta_fact_service_nom: info.serviceNumber,
        buildingName: info.buildingName,
        deliveryDate: info.deliveryDate,
        phone: info.phone,
        contactNameFacturation: info.contactNameFacturation,
        site_client_code: siteCode,
        presta_email: info.email
      }
      const items = []
      for (const ligne of lignes) {
        items.push({
          prestation: ligne.designation,
          qte: ligne.quantity,
          ca: ligne.rubriqueCa.RUBRIQUE_CA_CODE,
          type: {
            label: ligne.rubriqueCa.RUBRIQUE_CA_LIBELLE,
            tva: ligne.rubriqueCa.RUBRIQUE_CA_TVA,
            type: ligne.rubriqueCa.RUBRIQUE_CA_TYPE_PRESTATION,
            value: ligne.rubriqueCa.RUBRIQUE_CA_CODE
          },
          rubriqueprest: ligne.rubriquePresta,
          tva: ligne.tva,
          totalHt: ligne.totalHT,
          price: ligne.unitPrice,
          coutHt: "",
          prestaType: 1
        })
      }
      this.autrePrestaLignes =
        items.filter(({ type }) =>
          type.type.toString().toLowerCase().includes('autre')
        ).map(item => ({ ...item, prestaType: 2 })) || []
      this.prestaLignes = items.filter(({ type }) =>
        type.type.toString().toLowerCase().includes('alimentaire')
      )
      this.itemsExcel = generalInfo
      return response
    },
    async getProforma(siteCode, prestaDate) {
      const response = await getProforma(siteCode, prestaDate)
      this.proformaCode = response
      return response
    }
  }
})

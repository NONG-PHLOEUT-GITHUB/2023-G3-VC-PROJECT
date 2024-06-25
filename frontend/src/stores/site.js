import { defineStore } from 'pinia'
import { fetchSitesUser, getClientOptions, getClientSites } from '../api/site'

export const useSitesStore = defineStore('sites', {
	state: () => ({
		siteUser: [],
		clientSites: [],
		buList: [],
		responsableList: [],
		serviceList: []
	}),
	actions: {
		async getSitesUser() {
			const response = await fetchSitesUser()
			this.siteUser = response.data
		},
		async getClientSites(siteCode) {
			const response = await getClientSites(siteCode)
			this.clientSites = response.data
			return response
		},
		async getBuList(siteCode) {
			const response = await getClientOptions({ isBU: true, siteCode })
			this.buList = response.data
			return response
		},
		async getResponsableList(siteCode) {
			const response = await getClientOptions({ isResponsable: true, siteCode })
			this.responsableList = response.data
			return response
		},
		async getServiceList(siteCode) {
			const response = await getClientOptions({ isService: true, siteCode })
			this.serviceList = response.data
			return response
		}
	}
})

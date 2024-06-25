import { defineStore } from 'pinia'
import { fetchUserProfile } from '../api/user'

export const useUsersStore = defineStore('users', {
  state: () => ({
    userProfile: {},
    selectedSite: null,
    sites: []
  }),
  getters: {
    getProfile() {
      let data = this.userProfile;
      return data.profile_id;
    },
    getProfileLibelle() {
      let data = this.userProfile;
      return data.profile_libelle;
    }
  },
  actions: {
    async getUserProfile() {
      const response = await fetchUserProfile();
      this.userProfile = response.data;
      this.sites = response.data.sites
    },
    async setSelectedSite (selectedSite) {
      this.selectedSite = selectedSite;
    },
  }
})

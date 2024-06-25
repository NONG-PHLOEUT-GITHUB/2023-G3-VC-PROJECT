<template>
  <v-app-bar
    class="px-2"
    elevation="0"
    style="border-bottom: 4px solid #3071b3"
  >
    <template v-slot:prepend>
      <v-avatar class="avatar ml-3" size="large">
        <v-img
          :title="profileLibelle"
          :alt="profileLibelle"
          :src="profileImage"
        ></v-img>
      </v-avatar>
    </template>
    <v-app-bar-title>
      <v-col class="customselected" cols="6">
        <v-autocomplete
          v-model="selectedUser"
          :items="sites"
          :menu="true"
          hide-details
          variant="outlined"
          density="compact"
          class="customselect w-75"
          item-value="value"
          item-title="title"
          color="pr"
          @update:modelValue="filterPrestationBySiteCode"
        >
          <template #item="data">
            <v-list-subheader v-if="data.props.header" class="header">
              {{ data.props.header }}
            </v-list-subheader>
            <v-list-item
              v-else
              v-bind="data.props"
              class="title px-8 font-weight-bold"
            ></v-list-item>
          </template>
        </v-autocomplete>
      </v-col>
    </v-app-bar-title>
    <v-row>
      <v-tabs
        v-model="tab"
        align-tabs="center"
        class="vTabs"
        active-class="active-tab"
        hide-slider
      >
        <v-tab
          v-for="(row, i) in menus"
          :to="row.path"
          :key="i"
          :class="{ 'active-tab': tab === i }"
          class="text-none center-active text-h6 font-weight-bold"
        >
          <p class="paragraph">{{ row.title }}</p>
        </v-tab>
      </v-tabs>
    </v-row>
  </v-app-bar>
</template>

<script>
  import { mapActions, mapState } from 'pinia'
  import { useUsersStore } from '@/stores/user'
  import { usePrestationStore } from '../../stores/prestation'

  export default {
    name: 'NavBar',
    data: () => ({
      tab: null,
      isAdmin: false,
      selectedUser: null,
      isUpdating: false,
      isDialogUser: false,
      menus: [
        {
          path: '/prestation',
          title: 'Prestations annexes',
          icon: 'mdi-home'
        }
        /* {
	        path: "/gestion-admissions",
	        title: "Gestion admissions",
	        icon: "mdi-database-plus-outline",
	      },*/
      ]
    }),
    async created() {
      this.getUserProfile().then(() => {
        this.selectedUser =
          this.sites.length > 1 ? this.sites[1].value : this.sites[0].value
      })
    },
    watch: {
      selectedUser(siteCode) {
        if (siteCode) {
          this.setSelectedSite(siteCode)
          this.filterPrestationBySiteCode()
        }
      }
    },
    computed: {
      ...mapState(useUsersStore, ['userProfile', 'sites']),
      ...mapState(usePrestationStore, ['selectedCalendrier']),
      profileLibelle() {
        return useUsersStore().getProfileLibelle
      },
      profile() {
        return useUsersStore().getProfile
      },
      profileImage() {
        switch (this.profile) {
          case 1:
            return '/images/gerant.png' //Gérant
          case 2:
            return '/images/DE.png' //Directeur
          case 3:
            return '/images/siege.png' //siège
          default:
            return '/images/admin.png' //Administrateur
        }
      }
    },
    methods: {
      ...mapActions(useUsersStore, ['getUserProfile', 'setSelectedSite']),
      ...mapActions(usePrestationStore, ['getVisualisation']),

      async filterPrestationBySiteCode() {
        // get visualisation on main page only
        const currentRoute = this.$route.path
        if (this.selectedCalendrier && currentRoute === '/prestation') {
          this.getVisualisation({
            siteCode: this.selectedUser,
            selectedCalendrier: this.selectedCalendrier
          })
        }
      }
    }
  }
</script>

<style scoped>
  .active-tab {
    position: relative;
    margin-top: 10px;
    width: 50%;
    border-top: 3px solid #5d87ff;
    box-shadow: none !important;
  }
  .customselected {
    margin-top: -7px;
    margin-bottom: 4px;
  }
  .avatar {
    border: solid rgb(67, 133, 209);
  }
  .vTabs {
    color: #5d87ff;
    box-shadow: none !important;
  }
  .header {
    font-weight: bold;
  }
  .paragraph {
    margin-top: -25px;
    font-family: 'montserrat', sans-serif;
  }
</style>

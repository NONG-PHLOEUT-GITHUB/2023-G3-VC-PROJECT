<template>
  <custom-title class="text-primary" icon="mdi-room-service">
    <span v-if="selectedCalendrier" class="text-amber-darken-1 text-h8">
      - ({{ $t('title.presetationTitle.dateCloture') }}
      {{ selectedCalendrier.calendrier_cloture_date_fin }})
    </span>
  </custom-title>
  <v-container fluid>
    <v-row class="d-flex justify-space-between">
      <v-col cols="6" sm="3">
        <v-text-field
          variant="outlined"
          :label="$t(`common.search`)"
          class="mb-1"
          density="compact"
          v-model="search"
          clearable
          prepend-inner-icon="mdi-magnify"
        ></v-text-field>
      </v-col>
      <v-col cols="6" sm="2">
        <CustomSelect
          :items="calendriers"
          item-title="calendrier_cloture_periode"
          item-value="calendrier_cloture_periode"
          v-model="selectedCalendrier"
          return-object
          variant="outlined"
          hide-details
          @update:input="onChange"
        ></CustomSelect>
      </v-col>
    </v-row>
    <v-card variant="text">
      <v-data-table-virtual
        :headers="headers"
        :items="filteredItems"
        :header-props="{ class: 'bg-grey-lighten-5 text-subtitle-2 font-weight-bold' }"
        density="compact"
        fixed-header
        :sortable="true"
        class="elevation-1 fontSizeTable text-left"
        :height="400"
      >
        <template #[`item.presta_statut.libelle`]="{ item }">
          <div
            :class="getStatutColor(item)"
            style="padding: 2px"
            class="d-flex align-center justify-space-between rounded-pill px-2 p-1"
          >
            <span class="font-weight-bold">
              {{ item.presta_statut.libelle }}
            </span>
            <div v-if="item.totalPrestaJustif > 0" class="d-flex align-end">
              <v-icon>mdi-paperclip</v-icon>
            </div>
          </div>
        </template>

        <template #[`item.presta_fact_site_client_code.site_client_libelle`]="{ item }">
          <v-tooltip
            location="bottom"
            v-if="
              item.presta_fact_site_client_code.site_client_libelle != null &&
              item.presta_fact_site_client_code.site_client_libelle.length > 30
            "
            :text="item.presta_fact_site_client_code.site_client_libelle"
          >
            <template v-slot:activator="{ props }">
              <span style="cursor: pointer" v-bind="props">
                {{
                  truncateText(
                    item.presta_fact_site_client_code.site_client_libelle
                  )
                }}
              </span>
            </template>
          </v-tooltip>
          <span
            v-else-if="
              item.presta_fact_site_client_code.site_client_libelle != null &&
              item.presta_fact_site_client_code.site_client_libelle.length > 0
            "
          >
            {{ item.presta_fact_site_client_code.site_client_libelle }}
          </span>
          <span v-else>-</span>
        </template>
        <template #[`item.presta_fact_contact_nom`]="{ item }">
          <v-tooltip
            location="bottom"
            v-if="
              item.presta_fact_contact_nom != null &&
              item.presta_fact_contact_nom.length > 30
            "
            :text="item.presta_fact_contact_nom"
          >
            <template v-slot:activator="{ props }">
              <span style="cursor: pointer" v-bind="props">
                {{ truncateText(item.presta_fact_contact_nom) }}
              </span>
            </template>
          </v-tooltip>
          <span
            v-else-if="
              item.presta_fact_contact_nom != null &&
              item.presta_fact_contact_nom.length > 0
            "
          >
            {{ item.presta_fact_contact_nom }}
          </span>
          <span v-else>-</span>
        </template>
        <template #[`item.actions`]="{ item }">
          <v-btn
            v-if="item.presta_statut.id === 1 && isWriteMode()"
            variant="text"
            class="icon icon-color"
            size="medium"
            :to="{ path: `prestation/edit/${item.presta_entete_id}` }"
            icon="mdi-pencil"
          />
          <v-btn
            v-else
            variant="text"
            size="medium"
            class="icon icon-color"
            icon="mdi-text-box-search"
            replace
            :to="{ path: `prestation/edit/${item.presta_entete_id}` }"
          ></v-btn>
          <v-btn
            v-if="item.presta_statut.id === 1 && isWriteMode()"
            variant="text"
            size="medium"
            class="icon color-error"
            @click="openDeleteDialog(item)"
            icon="mdi-delete-empty"
          ></v-btn>
        </template>
        <template #body.append>
          <tr class="sticky-table-footer">
            <td colspan="5"></td>
            <td>
              <b>TOTAUX</b>
            </td>
            <td align="end" class="blue-text">
              {{ getCountTotalHT() }}
            </td>
            <td align="end" class="blue-text">
              {{ getCountTotalTTC() }}
            </td>
            <td></td>
          </tr>
        </template>
      </v-data-table-virtual>
    </v-card>
    <v-card-actions>
      <v-row>
        <v-col>
          <v-btn
            class="bg-violet pa-1 px-2 font-weight-bold"
            :to="{ path: '/statistiques' }"
          >
            {{ $t(`btn.statistiques`) }}
          </v-btn>
        </v-col>
        <v-col align="end">
          <v-btn
            v-if="isWriteMode()"
            class="importerXls pa-1 px-2 font-weight-bold"
            @click="importDialog = true"
          >
            {{ $t(`btn.importerXls`) }}
          </v-btn>
          <v-btn
            v-if="isWriteMode()"
            class="nouveau pa-1 px-2 font-weight-bold"
            :to="{ path: '/prestation/edit' }"
          >
            {{ $t(`btn.nouveau`) }}
          </v-btn>
        </v-col>
      </v-row>
    </v-card-actions>
  </v-container>
  <!-- delete dialog -->
  <v-dialog v-model="isDelete" width="400px">
    <v-card class="bg-dialog p-4">
      <v-card-text class="font-weight-bold" align="center">
        Vous êtes sur le point de supprimer cette prestation annexe.
      </v-card-text>
      <span class="pa-4" align="center">
        <strong>{{ itemData.presta_proforma }}</strong>
      </span>
      <v-card-actions class="py-4 d-flex justify-space-evenly">
        <v-btn
          class="font-weight-bold color-error"
          variant="outlined"
          width="40%"
          @click="isDelete = false"
        >
          {{ $t(`btn.annuler`) }}
        </v-btn>

        <v-btn
          class="font-weight-bold comfirm"
          variant="flat"
          width="40%"
          @click="deletePrestation(itemData.presta_entete_id)"
        >
          {{ $t(`btn.confirmer`) }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
  <DialogImportXls v-if="importDialog" v-model:importDialog="importDialog" />
</template>

<script>
  import EditPrestation from '@/components/dialog/EditPrestation.vue'
  import DialogImportXls from '@/components/dialog/DialogImportXls.vue'
  import CustomSelect from '@/components/global/CustomSelect.vue'
  import { mapState, mapActions } from 'pinia'
  import { useCalendrierStore } from '@/stores/calendrier'
  import { usePrestationStore } from '@/stores/prestation'
  import { useUsersStore } from '@/stores/user'

  export default {
    name: 'AdditionalService',
    props: {
      justifCount: {
        type: Number,
        required: false
      }
    },
    async created() {
      await this.getCalendrier()

      // Default on the current period
      if (this.calendriers.length) {
        this.selectedCalendrier = this.calendriers.filter(d => {
          return d.current === 1
        })[0]
      }
      if (this.selectedSite) {
        this.getVisualisation({
          siteCode: this.selectedSite,
          selectedCalendrier: this.selectedCalendrier
        })
      }
      await this.getServiceLigne()
    },
    data() {
      return {
        importDialog: false,
        isDelete: false,
        selectedCalendrier: null,
        search: '',
        filter: false,
        itemData: null,
        isSearch: false,
        periods: null,
        headers: [
          { title: 'Etat', key: 'presta_statut.libelle' },
          { title: 'N° Proformat', key: 'presta_proforma' },
          { title: 'Date prestation', key: 'presta_date' },
          { title: 'Client', key: 'presta_fact_site_client_code.site_client_libelle' },
          { title: 'Responsable', key: 'presta_fact_contact_nom' },
          { title: 'BU', key: 'presta_fact_bu' },
          {
            title: 'Total HT',
            key: 'totalHT',
            align: 'end',
            value: item =>
              this.$formatCurrency(item.totalHT, { precision: '2' })
          },
          {
            title: 'Total TTC',
            key: 'totalTTC',
            align: 'end',
            value: item =>
              this.$formatCurrency(item.totalTTC, { precision: '2' })
          },
          { title: '', key: 'actions' }
        ]
      }
    },
    computed: {
      ...mapState(useCalendrierStore, ['calendriers']),
      ...mapState(useUsersStore, ['userProfile', 'selectedSite']),
      ...mapState(usePrestationStore, ['visualLists', 'lignes']),
      filteredItems: {
        get() {
          const searchTerm = this.search
            ? this.search.toLowerCase()
            : this.search
          if (!searchTerm) {
            if (this.selectedCalendrier && this.filter) {
              const seletePeriod = this.selectedCalendrier
              const start = this.parseDate(
                seletePeriod.calendrier_cloture_date_debut
              )
              const end = this.parseDate(
                seletePeriod.calendrier_cloture_date_fin
              )
              return this.visualLists.filter(item => {
                const prestaDate = this.parseDate(item.presta_date)
                return prestaDate >= start && prestaDate <= end
              })
            }
            return this.visualLists
          }
          return this.visualLists.filter(item => {
            return (
              item.presta_statut.libelle.toLowerCase().includes(searchTerm) ||
              (item.presta_fact_site_client_code.site_client_libelle &&
                item.presta_fact_site_client_code.site_client_libelle
                  .toLowerCase()
                  .includes(searchTerm)) ||
              item.presta_date.toLowerCase().includes(searchTerm) ||
              item.presta_proforma.toLowerCase().includes(searchTerm) ||
              item.presta_fact_bu.toLowerCase().includes(searchTerm) ||
              item.totalTTC.toLowerCase().includes(searchTerm) ||
              item.totalHT.toLowerCase().includes(searchTerm) ||
              item.presta_fact_contact_nom.toLowerCase().includes(searchTerm) ||
              (item.presta_date >
                this.selectedCalendrier.calendrier_cloture_date_fin &&
                item.presta_date <
                  this.selectedCalendrier.calendrier_cloture_date_debut)
            )
          })
        },
        set(val) {
          return val
        }
      }
    },
    watch: {
      search(newSearch) {
        this.filterItems(newSearch)
      },
      filter(newVal) {
        this.onChange(newVal)
      },
      selectedCalendrier(period) {
        if (period) {
          this.setSelectedCalendrier(period)
          if (this.selectedSite) {
            this.getVisualisation({
              siteCode: this.selectedSite,
              selectedCalendrier: this.selectedCalendrier
            })
          }
        }
      }
    },
    methods: {
      ...mapActions(useCalendrierStore, ['getCalendrier']),
      ...mapActions(usePrestationStore, [
        'getVisualisation',
        'getServiceLigne',
        'deleteVisualisation',
        'setSelectedCalendrier'
      ]),
      onChange() {
        this.filter = true
      },
      parseDate(dateStr) {
        const [day, month, year] = dateStr.split('/').map(Number)
        return new Date(year, month - 1, day) // Month is 0-based in JavaScript Date
      },
      getStatutColor(item) {
        if (item.presta_statut.id === 1) {
          return 'bg-grey-darken-1'
        } else if (item.presta_statut.id === 2) {
          return 'bg-teal-accent-1 text-teal-accent-4 border-none'
        } else if (item.presta_statut.id === 3) {
          return 'bg-purple-accent-1'
        } else if (item.presta_statut.id === 4) {
          return 'bg-amber-lighten-4 text-amber-darken-2 border-none'
        } else if (item.presta_statut.id === 5) {
          return 'bg-violet'
        } else {
          return ''
        }
      },
      filterItems(searchTerm) {
        if (!searchTerm) {
          if (this.selectedCalendrier && this.filter) {
            const seletePeriod = this.selectedCalendrier
            const start = this.parseDate(
              seletePeriod.calendrier_cloture_date_debut
            )
            const end = this.parseDate(seletePeriod.calendrier_cloture_date_fin)
            return (this.filteredItems = this.visualLists.filter(item => {
              const prestaDate = this.parseDate(item.presta_date)
              return prestaDate >= start && prestaDate <= end
            }))
          }
          return this.visualLists
        }
        return (this.filteredItems = this.visualLists.filter(item => {
          return (
            item.presta_statut.libelle.toLowerCase().includes(searchTerm) ||
            (item.presta_fact_site_client_code.site_client_libelle &&
              item.presta_fact_site_client_code.site_client_libelle
                .toLowerCase()
                .includes(searchTerm)) ||
            item.presta_date.toLowerCase().includes(searchTerm) ||
            item.presta_proforma.toLowerCase().includes(searchTerm) ||
            item.presta_fact_bu.toLowerCase().includes(searchTerm) ||
            item.totalTTC.toLowerCase().includes(searchTerm) ||
            item.totalHT.toLowerCase().includes(searchTerm) ||
            item.presta_fact_contact_nom.toLowerCase().includes(searchTerm)
          )
        }))
      },
      getCountTotalHT() {
        let total = 0
        this.filteredItems.forEach(item => {
          const value = parseFloat(item.totalHT.replace(/[^\d.-]/g, ''))
          total += value
        })
        return new Intl.NumberFormat('fr-FR', {
          style: 'currency',
          currency: 'EUR'
        }).format(total)
      },
      getCountTotalTTC() {
        let total = 0
        this.filteredItems.forEach(item => {
          const value = parseFloat(item.totalTTC.replace(/[^\d.-]/g, ''))
          total += value
        })
        return new Intl.NumberFormat('fr-FR', {
          style: 'currency',
          currency: 'EUR'
        }).format(total)
      },
      truncateText(text) {
        return text.length > 10 ? text.slice(0, 20) + '...' : text
      },
      isWriteMode() {
        return (
          this.userProfile.profile_id == 1 || this.userProfile.profile_id == 4
        )
      },
      openDeleteDialog(item) {
        this.isDelete = true
        this.itemData = item
      },
      async deletePrestation(id) {
        this.isDelete = false
        await this.deleteVisualisation(id)
        await this.getVisualisation({
          siteCode: this.selectedSite,
          selectedCalendrier: this.selectedCalendrier
        })
      },
      getCountTotalHT() {
        let total = 0
        this.filteredItems.forEach(item => {
          const value = parseFloat(item.totalHT.replace(/[^\d.-]/g, ''))
          total += value
        })
        return new Intl.NumberFormat('fr-FR', {
          style: 'currency',
          currency: 'EUR'
        }).format(total)
      },
      getCountTotalTTC() {
        let total = 0
        this.filteredItems.forEach(item => {
          const value = parseFloat(item.totalTTC.replace(/[^\d.-]/g, ''))
          total += value
        })
        return new Intl.NumberFormat('fr-FR', {
          style: 'currency',
          currency: 'EUR'
        }).format(total)
      },
      truncateText(text) {
        return text.length > 50 ? text.slice(0, 50) + '...' : text
      },
      isWriteMode() {
        return (
          this.userProfile.profile_id == 1 || this.userProfile.profile_id == 4
        )
      }
    },
    components: {
      CustomSelect,
      DialogImportXls,
      EditPrestation
    }
  }
</script>

<style scoped>
  .icon {
    cursor: pointer;
  }
  .calendrier {
    margin-top: 0.3px;
  }
  .custom-hover:hover {
    background-color: blue !important;
  }

  .v-data-table tbody tr:nth-child(even) {
    background-color: #ecf2ff;
  }

  .v-data-table tbody tr:nth-child(odd) {
    background-color: #ffffff;
  }

  .sticky-table-footer td {
    font-weight: bold;
    position: sticky;
    bottom: 0;
    background-color: #f8f8f8;
  }

  .v-table__wrapper tbody tr:hover {
    background-color: rgba(255, 166, 0, 0.525);
  }
</style>

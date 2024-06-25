<template>
  <custom-title icon="mdi-room-service"></custom-title>
  <v-container fluid>
    <v-card variant="text" class="pa-md-4 mx-lg-auto bg-indigo-lighten-5">
      <v-card-text class="text-h6 ml-4">
        <strong>Ratio dépenses matières premières théorique et période</strong>
      </v-card-text>
      <v-row class="pa-md-8 mx-lg-auto">
        <v-col>
          <v-row>
            <span>Pauses :</span>
            <v-text-field
              density="compact"
              variant="outlined"
              v-model="pauses"
              class="input-width px-2"
            ></v-text-field>
          </v-row>
        </v-col>
        <v-col>
          <v-row>
            <span>Cocktails :</span>
            <v-text-field
              density="compact"
              variant="outlined"
              v-model="cocktails"
              class="px-2 input-width"
            ></v-text-field>
          </v-row>
        </v-col>
        <v-col>
          <v-row>
            <span>Repas :</span>
            <v-text-field
              density="compact"
              variant="outlined"
              v-model="repas"
              class="px-2 input-width"
            ></v-text-field>
          </v-row>
        </v-col>
        <v-col>
          <v-row>
            <span>Période :</span>
            <CustomSelect
              v-if="selectedCalendrier"
              :items="calendriers"
              variant="outlined"
              item-title="calendrier_cloture_periode"
              item-value="calendrier_cloture_periode"
              class="ml-4 py-3 mr-16 input-width"
              v-model="selectedCalendrier"
            ></CustomSelect>
          </v-row>
        </v-col>
      </v-row>
    </v-card>
    <v-data-table-virtual
      :headers="headers"
      :items="getStatistique"
      :sort-desc="[false, true]"
      :header-props="{ class: 'bg-grey-lighten-3 text-right' }"
      density="compact"
      fixed-header
      multi-sort
      class="elevation-1 mt-6 text-left"
      :height="250"
    >
      <!-- <template #[`item.date`]="{ item }">
        {{ item.presta_entete.presta_date }}
      </template> -->
      <template #body.append>
        <tr class="sticky-table-footer">
          <td>TOTAUX</td>
          <td align="end">{{ getTotalDenrees() }}</td>
          <td align="end">{{ getTotalBoissons() }}</td>
          <td align="end">{{ getTotalAutres() }}</td>
          <td align="end">{{ getTotalAlim() }}</td>
          <td align="end">{{ getTotalCoutDenrees() }}</td>
          <td align="end">{{ getTotalCoutBoissons() }}</td>
          <td align="end">{{ getTotalCoutPersonnel() }}</td>
          <td align="end">{{ getTotalCoutAutre() }}</td>
          <td></td>
        </tr>
        <tr class="sticky-table-footer">
          <td colspan="4"></td>
          <td align="end" class="text-black">
            <b>Ration de dépenses</b>
          </td>
          <td align="end">0%</td>
          <td align="end">0%</td>
          <td align="end"></td>
          <td align="start">0%</td>
          <td align="end">0%</td>
        </tr>
      </template>
      <template #no-data>
        {{ $t(`table.noDate`) }}
      </template>
    </v-data-table-virtual>
  </v-container>
</template>
<script>
  import CustomSelect from '@/components/global/CustomSelect.vue'
  import { mapActions, mapState } from 'pinia'
  import { useCalendrierStore } from '../../stores/calendrier'
  import { usePrestationStore } from '../../stores/prestation'

  export default {
    async created() {
      await this.getCalendrier()

      // Default on the current period
      if (this.calendriers.length) {
        this.selectedCalendrier = this.calendriers.filter(d => {
          return d.current === 1
        })[0]
      }
      const data = {
        periode: '04-06-2024',
        ratioPause: '50',
        ratioCocktails: '50',
        ratioRepas: '50'
      }
      await this.getStatistiques(data)
      await this.getServiceLigne()
    },
    data() {
      return {
        selectedCalendrier: null,
        repas: '50%',
        cocktails: '50%',
        pauses: '50%',
        headers: [
          {
            title: 'Date',
            key: 'date'
          },
          {
            title: 'CA Denrees HT',
            key: 'denrees',
            align: 'end',
            value: item => `. €`
          },
          {
            title: 'CA Boissons HT',
            key: 'boissons',
            align: 'end',
            value: item => `. €`
          },
          {
            title: 'CA Autres HT',
            key: 'autres',
            align: 'end',
            value: item => `. €`
          },
          {
            title: 'CA Total alim HT',
            key: 'totalAlim',
            align: 'end',
            value: item => `. €`
          },
          {
            title: 'Cout Denrees',
            key: 'coutDenrees',
            align: 'end',
            value: item => `. €`
          },
          {
            title: 'Cout Boissons',
            key: 'coutboissons',
            align: 'end',
            value: item => `. €`
          },
          {
            title: 'Cout Personnel',
            key: 'coutPersonnel',
            align: 'end',
            value: item => `. €`
          },
          {
            title: 'Cout Autre',
            key: 'coutAutre',
            align: 'end',
            value: item => `. €`
          },
          {
            title: 'Ratio depenses total',
            key: 'ratioTotal',
            align: 'end',
            value: item => `- %`
          }
        ],
        items: [
          {
            date: '01/03/24',
            denrees: '88',
            boissons: '',
            totalAlim: '',
            autres: '',
            coutDenrees: '44',
            coutboissons: '',
            coutPersonnel: '',
            coutAutre: '',
            ratoTotal: '50%'
          },
          {
            date: '01/03/24',
            denrees: '88',
            boissons: '',
            totalAlim: '',
            autres: '',
            coutDenrees: '44',
            coutboissons: '',
            coutPersonnel: '',
            coutAutre: '',
            ratoTotal: '50%'
          },
          {
            date: '01/03/24',
            denrees: '88',
            boissons: '',
            totalAlim: '',
            autres: '',
            coutDenrees: '44',
            coutboissons: '',
            coutPersonnel: '',
            coutAutre: '',
            ratoTotal: '50%'
          },
          {
            date: '01/03/24',
            denrees: '88',
            boissons: '',
            totalAlim: '',
            autres: '',
            coutDenrees: '44',
            coutboissons: '',
            coutPersonnel: '',
            coutAutre: '',
            ratoTotal: '50%'
          },
          {
            date: '01/03/24',
            denrees: '88',
            boissons: '',
            totalAlim: '',
            autres: '',
            coutDenrees: '44',
            coutboissons: '',
            coutPersonnel: '',
            coutAutre: '',
            ratoTotal: '50%'
          },
          {
            date: '01/03/24',
            denrees: '88',
            boissons: '',
            totalAlim: '',
            autres: '',
            coutDenrees: '44',
            coutboissons: '',
            coutPersonnel: '',
            coutAutre: '',
            ratoTotal: '50%'
          },
          {
            date: '01/03/24',
            denrees: '88',
            boissons: '',
            autres: '',
            totalAlim: '',
            coutDenrees: '44',
            coutboissons: '',
            coutPersonnel: '',
            coutAutre: '',
            ratoTotal: '50%'
          },
          {
            date: '01/03/24',
            denrees: '88',
            boissons: '',
            totalAlim: '',
            autres: '',
            coutDenrees: '44',
            coutboissons: '',
            coutPersonnel: '',
            coutAutre: '',
            ratoTotal: '50%'
          },
          {
            date: '01/03/24',
            denrees: '88',
            boissons: '',
            totalAlim: '',
            autres: '',
            coutDenrees: '44',
            coutboissons: '',
            coutPersonnel: '',
            coutAutre: '',
            ratoTotal: '50%'
          },
          {
            date: '01/03/24',
            denrees: '88',
            boissons: '',
            totalAlim: '',
            autres: '',
            coutDenrees: '44',
            coutboissons: '',
            coutPersonnel: '',
            coutAutre: '',
            ratoTotal: '50%'
          },
          {
            date: '01/03/24',
            denrees: '342',
            boissons: '78',
            autres: '',
            totalAlim: '',
            coutDenrees: '88',
            coutboissons: '35',
            coutPersonnel: '',
            coutAutre: '',
            ratoTotal: '25%'
          }
        ]
      }
    },
    computed: {
      ...mapState(useCalendrierStore, ['calendriers']),
      ...mapState(usePrestationStore, ['statistiues', 'lignes', 'visualLists']),
      getStatistique() {
        return this.statistiues
      }
    },
    methods: {
      ...mapActions(useCalendrierStore, ['getCalendrier']),
      ...mapActions(usePrestationStore, ['getStatistiques', 'getServiceLigne']),
      getRatioDepenseTotal() {
        return '- %'
      },
      getTotalDenrees() {
        return '. €'
      },
      getTotalBoissons() {
        return '. €'
      },
      getTotalAutres() {
        return '. €'
      },
      getTotalAlim() {
        return '. €'
      },
      getTotalCoutDenrees() {
        return '. €'
      },
      getTotalCoutBoissons() {
        return '. €'
      },
      getTotalCoutPersonnel() {
        return '. €'
      },
      getTotalCoutAutre() {
        return '. €'
      }
    },
    components: {
      CustomSelect
    }
  }
</script>
<style>
  .v-field__input {
    background-color: white !important;
    padding-top: 3px;
    padding-bottom: 3px;
    min-height: 30px;
  }
  .input-width {
    width: 10%;
    margin-right: 190px;
    margin-left: 8px;
  }
  .sticky-table-footer {
    font-weight: bold;
    position: sticky;
    bottom: 0;
    background-color: #f8f8f8;
  }
</style>

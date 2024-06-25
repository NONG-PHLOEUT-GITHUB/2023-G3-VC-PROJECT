<template>
  <custom-title
    v-if="promisePrestationInfo"
    icon="mdi-room-service"
    :title="prestaTitleType.title"
  >
    <template #right>
      <v-btn
        class="importerXls pa-1 px-4 font-weight-bold"
        @click="showJustificatifDialog"
      >
        {{ $t(`btn.justificatifs`) }}
        <template #append>
          <div
            v-if="justifCount > 0"
            class="bg-amber-accent-3 font-weight-bold rounded-circle mx-auto text-white"
            style="width: 22px; height: 22px; border: 1px solid white"
          >
            {{ justifCount }}
          </div>
        </template>
      </v-btn>
    </template>
    <span v-if="prestaTitleType.type === 4" class="text-amber-darken-1 text-h8">
      {{
        ` - (${$t('title.presetationTitle.accountIntegrated', {
          date: `${this.prestation.headerInfor.presta_x3_integration_date} - N° Facture ${this.prestation.headerInfor.presta_facture_proforma}`
        })})`
      }}
    </span>
    <span
      v-else-if="prestaTitleType.type === 3"
      class="text-amber-darken-1 text-h8"
    >
      {{
        ` - (${$t('title.presetationTitle.accountIntegrated', {
          date: `${this.prestation.headerInfor.presta_x3_integration_date}`
        })})`
      }}
    </span>
  </custom-title>
  <v-container v-if="promisePrestationInfo" fluid>
    <v-card-text
      class="px-6 py-4 pl-8 pr-8 fontSizeTable rounded-lg"
      style="background-color: #ecf2ff"
    >
      <v-row no-gutters>
        <v-col>
          <v-row class="mb-3" no-gutters>
            <v-col col="8">
              <span class="pa-2 text-h6 font-weight-bold ma-2">
                {{ $t('prestation.invoiceProforma') }} N°
                <span v-if="!isCreate" class="blue-text">
                  {{ prestation.headerInfor.presta_proforma }}
                </span>
                <span v-else class="blue-text">
                  {{ proformaCode }}
                </span>
              </span>
            </v-col>
            <v-col md="2"></v-col>
          </v-row>
          <v-row class="mb-3 mt-4" no-gutters>
            <v-col md="4">
              <span class="pa-4">{{ $t('prestation.datePresta') }} :</span>
            </v-col>
            <v-col md="6">
              <v-menu
                v-model="datePickerPrestaDate"
                transition="scale-transition"
                offset-y
                :close-on-content-click="false"
              >
                <template #activator="{ props }">
                  <v-text-field
                    :model-value="prestaDateFormat"
                    v-bind="props"
                    style="width: 30%"
                    hide-details
                    readonly
                    density="compact"
                    variant="outlined"
                  />
                </template>
                <v-date-picker
                  v-model="prestationDate"
                  :show-adjacent-months="false"
                  :show-current="false"
                  :max="prestaDateMax"
                  :min="prestaDateMin"
                  color="primary"
                  scrollable
                  hide-header
                  @update:modelValue="checkIfDateValid"
                />
              </v-menu>
            </v-col>
          </v-row>
          <v-row class="mb-3 mt-4" no-gutters>
            <v-col md="4">
              <span class="pa-4">Quantité Pauses/Ptt Dej/Sandwichs :</span>
            </v-col>
            <v-col md="6">
              <span class="pl-1 font-weight-bold">
                {{ totalRubriquePresta.A2 }}
              </span>
            </v-col>
          </v-row>
          <v-row class="mb-3 mt-4" no-gutters>
            <v-col md="4">
              <span class="pa-4">Quantité Cocktails :</span>
            </v-col>
            <v-col md="6">
              <span class="pl-1 font-weight-bold">
                {{ totalRubriquePresta.A1 }}
              </span>
            </v-col>
          </v-row>
          <v-row class="mb-3 mt-5" no-gutters>
            <v-col md="4">
              <span class="pa-4">Quantité Repas :</span>
            </v-col>
            <v-col md="6">
              <span class="pl-1 font-weight-bold">
                {{ totalRubriquePresta.A3 }}
              </span>
            </v-col>
          </v-row>
          <v-row class="mt-6" no-gutters>
            <v-col md="4">
              <span class="pa-4">{{ $t('prestation.email') }} * :</span>
            </v-col>
            <v-col md="8">
              <v-text-field
                v-model="formData.presta_email"
                class="w-50"
                density="compact"
                variant="outlined"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-col>
        <v-col>
          <v-row class="mb-3 mt-2" no-gutters>
            <v-col md="3">
              <span class="pa-4">{{ $t('prestation.client') }} * :</span>
            </v-col>
            <v-col md="9">
              <v-text-field
                v-if="isManagementBU || isManagementResp"
                :value="formData.site_client_code"
                :disabled="true"
                hide-details
                variant="outlined"
                class="mt-4"
                density="compact"
              ></v-text-field>
              <CustomSelect
                v-else
                v-model="formData.site_client_code"
                :items="clientSites"
                class="blue-text font-weight-bold"
                item-title="siteLabel"
                item-value="siteCode"
                hide-details
                variant="outlined"
              ></CustomSelect>
            </v-col>
          </v-row>
          <v-row class="mb-3 mt-4" no-gutters>
            <v-col md="3">
              <span class="pa-4">
                {{ $t('prestation.bu') }}
                <!--*-->
                :
              </span>
            </v-col>
            <v-col md="9">
              <v-text-field
                v-if="isManagementClient || isManagementResp"
                v-model="formData.presta_fact_bu"
                hide-details
                variant="outlined"
                density="compact"
              ></v-text-field>
              <CustomSelect
                v-else
                v-model="formData.presta_fact_bu"
                :items="buList"
                item-title="label"
                item-value="value"
                hide-details
                variant="outlined"
              ></CustomSelect>
            </v-col>
          </v-row>
          <v-row class="mb-3 mt-5" no-gutters>
            <v-col md="3">
              <span class="pa-4">{{ $t('prestation.codeImputation') }} :</span>
            </v-col>
            <v-col md="9">
              <v-text-field
                v-model="formData.presta_fact_code_imputation"
                hide-details
                variant="outlined"
                density="compact"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row class="mb-3 mt-5" no-gutters>
            <v-col md="3">
              <span class="pa-4">{{ $t('prestation.numCommande') }} * :</span>
            </v-col>
            <v-col md="9">
              <v-text-field
                v-model="formData.presta_fact_numero_commande"
                :disabled="isManagementResp"
                hide-details
                variant="outlined"
                density="compact"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row class="mb-3 mt-5" no-gutters>
            <v-col md="3">
              <span class="pa-4">{{ $t('prestation.service') }} :</span>
            </v-col>
            <v-col md="9">
              <v-text-field
                v-model="formData.presta_fact_service_nom"
                hide-details
                variant="outlined"
                density="compact"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row class="mb-3 mt-6" no-gutters>
            <v-col md="3">
              <span class="pa-4">
                {{ $t('prestation.responsible') }}
                {{ isResponsableMandatory ? '*' : '' }} :
              </span>
            </v-col>
            <v-col md="9">
              <v-text-field
                v-if="isManagementClient || isManagementBU"
                v-model="formData.presta_fact_contact_nom"
                hide-details
                variant="outlined"
                density="compact"
              ></v-text-field>
              <CustomSelect
                v-else
                v-model="formData.presta_fact_contact_nom"
                :items="responsableList"
                item-title="label"
                item-value="label"
                hide-details
                variant="outlined"
                @update:modelValue="onChangeResp"
              ></CustomSelect>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
      <v-row no-gutters>
        <v-row class="comment mt-2" no-gutters>
          <v-col md="2">
            <span class="pa-4">{{ $t('prestation.cmt') }} :</span>
          </v-col>
          <v-col>
            <v-text-field
              v-model="formData.presta_commentaire"
              variant="outlined"
              density="compact"
              @input="
                formData.presta_commentaire.includes(';')
                  ? (formData.presta_commentaire =
                      formData.presta_commentaire.replace(';', ''))
                  : ''
              "
            ></v-text-field>
          </v-col>
        </v-row>
      </v-row>
    </v-card-text>
    <v-card variant="text" class="mt-4">
      <v-data-table-virtual
        :headers="headerPrestation"
        :header-props="{ class: 'bg-grey-lighten-3 text-subtitle-2 font-weight-bold' }"
        :items="prestations"
        density="compact"
        class="fontSizeTable"
        height="315px"
        hover
        fixed-header
      >
        <template #[`item.ca`]="{ item }">
          <CustomSelect
            v-model="item.ca"
            variant="outlined"
            style="margin-top: -6%;"
            :items="rubriqueCaItems"
            item-title="label"
            item-value="value"
          ></CustomSelect>
        </template>
        <template #[`item.rubriqueprest`]="{ item }">
          <CustomSelect
            v-model="item.rubriqueprest"
            variant="outlined"
            style="margin-top: -6%;"
            :items="rubriquesPresta"
            item-title="label"
            item-value="value"
          ></CustomSelect>
        </template>
        <template #[`item.prestation`]="{ item }">
          <v-text-field
            variant="outlined"
            density="compact"
            class="mt-2"
            v-model="item.prestation"
            @input="
              item.prestation.includes(';')
                ? (item.prestation = item.prestation.replace(';', ''))
                : ''
            "
          />
        </template>
        <template #[`item.qte`]="{ item }">
          <v-text-field
            variant="outlined"
            density="compact"
            class="mt-2"
            v-model="item.qte"
            :suffix="item.qte == '' ? '-' : ''"
            type="number"
            :hide-spin-buttons="true"
            @input="
              item.qte < 0
                ? (item.qte = '')
                : item.qte.includes('.')
                  ? (item.qte = item.qte.substring(0, item.qte.indexOf('.')))
                  : ''
            "
          ></v-text-field>
        </template>
        <template #[`item.price`]="{ item }">
          <v-text-field
            variant="outlined"
            class="mt-2"
            density="compact"
            v-model="item.price"
            :suffix="item.price == '' ? '- €' : '€'"
            type="number"
            :hide-spin-buttons="true"
            @input="item.price = getPrice(item.price)"
          ></v-text-field>
        </template>
        <template #[`item.actions`]="{ item }">
          <v-btn
            v-if="!isVisu && isLineValid(item)"
            variant="text"
            @click="onDeleteLigne(true, item.ligneId)"
          >
            <v-icon size="large" class="color-error">mdi-delete-empty</v-icon>
          </v-btn>
        </template>
        <template #[`item.totalHt`]="{ item }">
          {{ this.$formatCurrency(getLineTotalHT(item), { precision: '2' }) }}
        </template>
        <template #[`item.coutHt`]="{ item }">
          {{ this.$formatCurrency(getLineCoutHT(item), { precision: '2' }) }}
        </template>
        <template #no-data>
          {{ $t(`table.noDate`) }}
        </template>
      </v-data-table-virtual>
      <hr />
    </v-card>
    <v-card class="mt-4" variant="text">
      <v-data-table-virtual
        :headers="headerAutrePrestation"
        class="fontSizeTable"
        :header-props="{ class: 'bg-grey-lighten-3 text-subtitle-2 font-weight-bold' }"
        density="compact"
        height="175px"
        fixed-header
        hover
        :items="autrePrestations"
      >
        <template #[`item.ca`]="{ item }">
          <CustomSelect
            v-model="item.ca"
            variant="outlined"
            style="margin-top: -6%;"
            :items="autreRubriqueCaItems"
            item-title="label"
            item-value="value"
          ></CustomSelect>
        </template>
        <template #[`item.rubriqueprest`]="{ item }">
          <CustomSelect
            v-model="item.rubriqueprest"
            variant="outlined"
            :items="rubriquesPresta"
            item-title="label"
            style="margin-top: -6%;"

            item-value="value"
          ></CustomSelect>
        </template>
        <template #[`item.prestation`]="{ item }">
          <v-text-field
            variant="outlined"
            class="mt-2"
            density="compact"
            v-model="item.prestation"
            @input="
              item.prestation.includes(';')
                ? (item.prestation = item.prestation.replace(';', ''))
                : ''
            "
          ></v-text-field>
        </template>
        <template #[`item.qte`]="{ item }">
          <v-text-field
            variant="outlined"
            class="mt-2"
            density="compact"
            v-model="item.qte"
            :suffix="item.qte == '' ? '-' : ''"
            type="number"
            :hide-spin-buttons="true"
            @input="
              item.qte < 0
                ? (item.qte = '')
                : item.qte.includes('.')
                  ? (item.qte = item.qte.substring(0, item.qte.indexOf('.')))
                  : ''
            "
          ></v-text-field>
        </template>
        <template #[`item.price`]="{ item }">
          <v-text-field
            variant="outlined"
            class="mt-2"
            :suffix="item.price == '' ? '- €' : '€'"
            density="compact"
            v-model="item.price"
            type="number"
            :hide-spin-buttons="true"
            @input="item.price = getPrice(item.price)"
          ></v-text-field>
        </template>
        <template #[`item.totalHt`]="{ item }">
          {{
            this.$formatCurrency(getLineAutrePrestaTotalHT(item), {
              precision: '2'
            })
          }}
        </template>
        <template #[`item.coutHt`]="{ item }">
          <v-text-field
            variant="outlined"
            class="ml-14"
            :suffix="item.coutHt == '' || item.coutHt == '-' ? '- €' : '€'"
            density="compact"
            style="width: 60%"
            v-model="item.coutHt"
          ></v-text-field>
        </template>
        <template #[`item.actions`]="{ item }">
          <v-btn
            v-if="!isVisu && isLineValid(item)"
            variant="text"
            @click="onDeleteLigne(false, item.ligneId)"
          >
            <v-icon size="large" class="color-error">mdi-delete-empty</v-icon>
          </v-btn>
        </template>
        <template #no-data>
          {{ $t(`table.noDate`) }}
        </template>
      </v-data-table-virtual>
      <hr />
    </v-card>
    <v-row width="98%">
      <v-col style="font-size: x-large" class="text-blue-lighten-1">
        <v-row class="blue-text d-flex justify-center mt-16">
          <strong>
            {{ $t('prestation.totalCostHt') }} :
            {{ $formatCurrency(getCoutTotalHT(), { precision: '2' }) }}
          </strong>
        </v-row>
        <v-row class="blue-text d-flex justify-center mt-5">
          <strong>
            {{ $t('prestation.totalRatio') }} :
            {{
              $formatCurrency(getRatioDepenseTotal(), {
                symbol: '%',
                precision: '0'
              })
            }}
          </strong>
        </v-row>
      </v-col>
      <v-col>
        <v-card align="end" class="mt-4" variant="text">
          <v-data-table-virtual
            :headers="headersData3"
            density="compact"
            :header-props="{ class: 'bg-grey-lighten-3 text-subtitle-2 font-weight-bold' }"
            fixed-header
            disabled-hover
            :items="tableData3"
            width="70%"
            class="blue-text fontSizeTable no-hover font-weight-bold"
          >
            <template #body.append="{ item }">
              <tr>
                <td colspan="2"></td>
                <td class="text-black">
                  <b>{{ $t('prestation.netPay') }}</b>
                </td>
                <td>
                  <b>
                    {{
                      this.$formatCurrency(getTotalTTC(), { precision: '2' })
                    }}
                  </b>
                </td>
              </tr>
            </template>
          </v-data-table-virtual>
          <v-card-actions class="mt-2 d-flex justify-end">
            <v-btn
              v-if="!isVisu"
              variant="outlined"
              class="mr-4 color-error font-weight-bold pa-1 px-4"
              @click="clearData"
            >
              {{ $t(`btn.annuler`) }}
            </v-btn>
            <v-btn
              v-else
              variant="outlined"
              class="mr-4 font-weight-bold pa-1 px-4 importerXls"
              @click="clearData"
            >
              {{ $t(`btn.fermer`) }}
            </v-btn>
            <v-btn
              v-if="!isVisu"
              class="mr-4 font-weight-bold bg-grey-lighten-3 pa-1 px-4"
              variant="text"
              @click="onSave(true)"
            >
              {{ $t(`btn.brouillon`) }}
            </v-btn>
            <v-btn
              v-if="!isVisu"
              class="importerXls font-weight-bold pa-1 px-4"
              @click="onSave(false)"
            >
              {{ $t(`btn.envoyer`) }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
  <v-dialog width="350px" v-model="dialogVisible">
    <v-card
      class="rounded bg-dialog"
      style="font-size: 12px; text-align: start"
    >
      <v-card-text class="font-weight-bold">
        {{ $t('title.sendValidate') }}
      </v-card-text>

      <v-card-actions>
        <v-btn
          variant="outlined"
          max-height="28px"
          class="color-error px-4 ml-3 font-weight-bold"
          @click="dialogVisible = false"
        >
          {{ $t(`btn.annuler`) }}
        </v-btn>
        <v-spacer></v-spacer>

        <v-btn
          variant="flat"
          max-height="28px"
          class="px-4 importerXls mr-3 font-weight-bold"
          @click="closeDialog"
        >
          {{ $t(`btn.envoyer`) }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
  <JustificatifDialog
    v-if="isJustificatifVisible"
    v-model="isJustificatifVisible"
    :is-visu="isVisu"
  />
</template>

<script>
  import CustomSelect from '../global/CustomSelect.vue'
  import JustificatifDialog from '../common/JustificatifDialog.vue'
  import { mapState, mapActions } from 'pinia'
  import { usePrestationStore } from '@/stores/prestation'
  import { useSitesStore } from '@/stores/site'
  import { useRubriqueCAStore } from '@/stores/rubriqueCA'
  import { useRubriquePrestaStore } from '@/stores/rubriquePrestation'
  import { useCalendrierStore } from '@/stores/calendrier'
  import { useUsersStore } from '@/stores/user'
  import { usePrestaionJustifStore } from '@/stores/prestationJustif'
  export default {
    async created() {
      this.clearJustif()
      if (this.$route.params.id != '') {
        this.isCreate = false
        await this.prepareData()
        if (this.prestation.headerInfor.presta_statut.id !== 1) {
          this.isVisu = true
        }
        this.promisePrestation = true
      } else {
        //Reset data
        this.formData = this.$route.query.generainfo
          ? JSON.parse(this.$route.query.generainfo)
          : {}
        this.prestation.prestaLignes = this.$route.query.prestaLignes
          ? JSON.parse(this.$route.query.prestaLignes)
          : []
        this.prestation.autrePrestaLignes = this.$route.query.autrePrestaLignes
          ? JSON.parse(this.$route.query.autrePrestaLignes)
          : []
        this.promisePrestation = true
        // Initialize prestation date
        this.formData.presta_date = new Date()
      }

      await this.checkIfDateValid()
      await this.getDataList()
      await this.getAllRubriqueCa()
      await this.getAllRubriquePrestation()
    },
    components: {
      CustomSelect,
      JustificatifDialog
    },
    data() {
      return {
        data: null,
        isJustificatifVisible: false,
        dialogVisible: false,
        promisePrestation: false,
        formData: { presta_date: '' },
        isCreate: true,
        isVisu: false,
        datePickerPrestaDate: false,
        prestaDateMin: '',
        prestaDateMax: '',
        isBrouillon: true,
        headerPrestation: [
          {
            title: this.$t('prestation.tableColumns.rubCa'),
            key: 'ca',
            width: 250
          },
          {
            title: this.$t('prestation.tableColumns.rubPresta'),
            key: 'rubriqueprest',
            width: 250
          },
          {
            title: this.$t('prestation.tableColumns.presta'),
            key: 'prestation'
          },
          {
            title: this.$t('prestation.tableColumns.qty'),
            key: 'qte',
            width: 100
          },
          {
            title: this.$t('prestation.tableColumns.unitPrice'),
            key: 'price',
            width: 150
          },
          {
            title: this.$t('prestation.tableColumns.totalHt'),
            key: 'totalHt',
            align: 'end',
            width: 150
          },
          {
            title: this.$t('prestation.tableColumns.costExcludeTax'),
            key: 'coutHt',
            align: 'end',
            width: 150
          },
          {
            title: '',
            key: 'actions',
            width: 100
          }
        ],
        headerAutrePrestation: [
          {
            title: this.$t('prestation.tableColumns.rubCa'),
            key: 'ca',
            width: 250
          },
          {
            title: this.$t('prestation.tableColumns.rubPresta'),
            key: 'rubriqueprest',
            width: 250
          },
          {
            title: this.$t('prestation.tableColumns.otherPresta'),
            key: 'prestation'
          },
          {
            title: this.$t('prestation.tableColumns.qty'),
            key: 'qte',
            width: 100
          },
          {
            title: this.$t('prestation.tableColumns.unitPrice'),
            key: 'price',
            width: 150
          },
          {
            title: this.$t('prestation.tableColumns.totalHt'),
            key: 'totalHt',
            align: 'end',
            width: 150
          },
          {
            title: this.$t('prestation.tableColumns.costCalculateTax'),
            key: 'coutHt',
            align: 'end',
            width: 180
          },
          {
            title: '',
            key: 'actions',
            width: 100
          }
        ],
        headersData3: [
          {
            title: this.$t('prestation.tableColumns.baseTva'),
            key: 'base',
            align: 'end'
          },
          {
            title: this.$t('prestation.tableColumns.rateTva'),
            key: 'taux',
            align: 'end'
          },
          {
            title: this.$t('prestation.tableColumns.risingTva'),
            key: 'montant',
            align: 'end'
          },
          {
            title: this.$t('prestation.tableColumns.totalTtc'),
            key: 'total',
            align: 'end'
          }
        ]
      }
    },
    computed: {
      ...mapState(usePrestationStore, ['prestation', 'lignes', 'proformaCode']),
      ...mapState(useSitesStore, [
        'clientSites',
        'buList',
        'responsableList',
        'serviceList'
      ]),
      ...mapState(useRubriqueCAStore, ['rubriquesCa']),
      ...mapState(useRubriquePrestaStore, ['rubriquesPresta']),
      ...mapState(useCalendrierStore, ['calendriers']),
      ...mapState(useUsersStore, ['selectedSite']),
      ...mapState(usePrestaionJustifStore, [
        'prestaJustifs',
        'selectedJustifFiles'
      ]),

      tableData3() {
        return [
          {
            base: this.$formatCurrency(this.getTotalBaseTVAByTVA(0), {
              precision: '2'
            }),
            taux: '0%',
            montant: this.$formatCurrency(this.getTotalMontantTVAByTVA(0), {
              precision: '2'
            }),
            total: this.$formatCurrency(this.getTotalTTCByTVA(0), {
              precision: '2'
            })
          },
          {
            base: this.$formatCurrency(this.getTotalBaseTVAByTVA(10), {
              precision: '2'
            }),
            taux: '10%',
            montant: this.$formatCurrency(this.getTotalMontantTVAByTVA(10), {
              precision: '2'
            }),
            total: this.$formatCurrency(this.getTotalTTCByTVA(10), {
              precision: '2'
            })
          },
          {
            base: this.$formatCurrency(this.getTotalBaseTVAByTVA(20), {
              precision: '2'
            }),
            taux: '20%',
            montant: this.$formatCurrency(this.getTotalMontantTVAByTVA(20), {
              precision: '2'
            }),
            total: this.$formatCurrency(this.getTotalTTCByTVA(20), {
              precision: '2'
            })
          }
        ]
      },
      promisePrestationInfo() {
        return this.promisePrestation
      },
      prestations() {
        let resta = this.prestation.prestaLignes || []
        const dataLength = 50 - resta.length
        for (let i = 0; i < dataLength; i++) {
          resta.push({
            ligneId: 'presta' + i,
            prestation: '',
            qte: '',
            price: '',
            ca: '-',
            rubriqueprest: '-',
            totalHt: '',
            coutHt: '',
            prestaType: 1
          })
        }
        return resta
      },
      autrePrestations() {
        let autrePresta = this.prestation.autrePrestaLignes || []
        const dataLength = 20 - autrePresta.length
        for (let i = 0; i < dataLength; i++) {
          autrePresta.push({
            ligneId: 'presta' + i,
            prestation: '',
            qte: '',
            price: '',
            ca: '-',
            rubriqueprest: '-',
            totalHt: '',
            coutHt: '',
            prestaType: 2
          })
        }
        return autrePresta
      },
      totalRubriquePresta() {
        let countPrestations = {
          A1: 0,
          A2: 0,
          A3: 0
        }
        const prestationList = this.prestations.concat(this.autrePrestations)
        prestationList.forEach(item => {
          if (item.rubriqueprest !== '' && item.rubriqueprest !== '-') {
            if (item.rubriqueprest == 'A1') {
              countPrestations.A1 +=
                item.qte !== '' && item.qte !== '-' ? item.qte * 1 : 0
            } else if (item.rubriqueprest == 'A2') {
              countPrestations.A2 +=
                item.qte !== '' && item.qte !== '-' ? item.qte * 1 : 0
            } else {
              countPrestations.A3 +=
                item.qte !== '' && item.qte !== '-' ? item.qte * 1 : 0
            }
          }
        })
        return countPrestations
      },
      prestaTitleType() {
        const prestaStatus = this.prestation.headerInfor
          ? this.prestation.headerInfor.presta_statut.id
          : 1
        let titleType = {
          title: this.$t('title.presetationTitle.viewServiceTitle'),
          type: prestaStatus
        }
        if (prestaStatus === 1) {
          titleType.title = this.$t('title.presetationTitle.draftTitle')
        }
        if (this.isCreate && !this.$route.query.generainfo) {
          titleType.title = this.$t('title.presetationTitle.createTitle')
        }
        return titleType
      },
      rubriqueCaItems() {
        const rubriquesCa = this.rubriquesCa.filter(({ type }) =>
          type.toString().toLowerCase().includes('alimentaire')
        )
        return rubriquesCa
      },
      autreRubriqueCaItems() {
        const autreRubriquesCa =
          this.rubriquesCa.filter(({ type }) =>
            type.toString().toLowerCase().includes('autre')
          ) || []
        return autreRubriquesCa
      },
      prestationDate: {
        get() {
          let newDate = null
          const prestaDate = this.formData.presta_date || ''
          if (prestaDate !== '') {
            if (prestaDate.toString().indexOf('/') === -1) {
              newDate = prestaDate
            } else {
              newDate = this.getDateFromString(prestaDate)
            }
          } else {
            return null
          }
          return newDate
        },
        set(val) {
          this.formData.presta_date = val
        }
      },
      prestaDateFormat() {
        const prestaDate = this.formData.presta_date || ''
        if (prestaDate !== '' && prestaDate.toString().indexOf('/') == -1) {
          const newDate = new Date(prestaDate)
          const date = newDate.getDate()
          const month = newDate.getMonth() + 1
          const dateFormat = `${date < 10 ? '0' + date : date}/${month < 10 ? '0' + month : month}/${newDate.getFullYear()}`
          return dateFormat
        }
        return prestaDate
      },
      justifCount() {
        const justifFiles = this.prestaJustifs.concat(this.selectedJustifFiles)
        return justifFiles.length > 0 ? justifFiles.length : ''
      },
      isManagementClient() {
        return (
          this.buList &&
          this.buList.length == 0 &&
          this.responsableList &&
          this.responsableList.length == 0
        )
      },
      isManagementBU() {
        return this.buList && this.buList.length > 0
      },
      isManagementResp() {
        return this.responsableList && this.responsableList.length > 0
      },
      isNumeroCommandMandatory() {
        return true
      },
      isResponsableMandatory() {
        return this.isManagementResp
      },
      isValidNumeroCommand() {
        return (
          !this.isNumeroCommandMandatory ||
          this.formData.presta_fact_numero_commande != ''
        )
      },
      prestationLignes() {
        const lignes = this.prestations
          .concat(this.autrePrestations)
          .map(item => {
            let itemData = {}
            if (this.isLineValid(item)) {
              itemData['prestaLigneId'] =
                item.ligneId && item.ligneId.toString().includes('presta')
                  ? undefined
                  : item.ligneId
              itemData['prestaDesignation'] = item.prestation
              itemData['quantite'] =
                item.qte && item.qte.toString().indexOf('-') !== -1
                  ? item.qte.replace('-', '')
                  : item.qte
              itemData['prixUnitaire'] =
                item.price && item.price.toString().indexOf('-') !== -1
                  ? item.price.replace('-', '')
                  : item.price
              itemData['rubriqueCaCode'] =
                item.ca && item.ca.toString().indexOf('-') !== -1
                  ? item.ca.replace('-', '')
                  : item.ca
              itemData['rubriquePrestaCode'] =
                item.rubriqueprest &&
                item.rubriqueprest.toString().indexOf('-') !== -1
                  ? item.rubriqueprest.replace('-', '')
                  : item.rubriqueprest
              itemData['prestaType'] = item.prestaType
              itemData['coutHt'] =
                item.coutHt && item.coutHt.toString().indexOf('-') !== -1
                  ? item.coutHt.replace('-', '')
                  : item.coutHt
              return itemData
            }
          })
          .filter(item => item != null)
        return lignes
      },
      formValidate() {
        let erorMessages = ''
        if (this.formData.presta_email && this.formData.presta_email !== '') {
          const pattern =
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
          if (!pattern.test(this.formData.presta_email)) {
            erorMessages += `- ${this.$t('rules.invalidEmail')}<br />`
          }
        } else {
          erorMessages += `- ${this.$t('rules.fieldRequired', { field: this.$t('prestation.email') })}<br />`
        }
        if (
          this.isManagementClient ||
          this.isManagementBU ||
          this.isManagementResp
        ) {
          if (
            !this.formData.site_client_code ||
            this.formData.site_client_code === ''
          ) {
            erorMessages += `- ${this.$t('rules.fieldRequired', { field: this.$t('prestation.client') })}<br />`
          }
        }
        if (this.isManagementBU) {
          if (
            !this.formData.presta_fact_bu ||
            this.formData.presta_fact_bu === ''
          ) {
            erorMessages += `- ${this.$t('rules.fieldRequired', { field: this.$t('prestation.bu') })}<br />`
          }
        }
        if (this.isResponsableMandatory) {
          if (
            !this.formData.presta_fact_contact_nom ||
            this.formData.presta_fact_contact_nom === ''
          ) {
            erorMessages += `- ${this.$t('rules.fieldRequired', { field: this.$t('prestation.responsible') })}<br />`
          }
          if (
            !this.formData.presta_fact_service_nom ||
            this.formData.presta_fact_service_nom === ''
          ) {
            erorMessages += `- ${this.$t('rules.fieldRequired', { field: this.$t('prestation.service') })}<br />`
          }
        }
        if (
          this.isNumeroCommandMandatory &&
          (!this.formData.presta_fact_numero_commande ||
            this.formData.presta_fact_numero_commande === '')
        ) {
          erorMessages += `- ${this.$t('rules.fieldRequired', { field: this.$t('prestation.numCommande') })}<br />`
        }
        if (this.prestationLignes.length == 0) {
          erorMessages += `- ${this.$t('rules.noPrestation')}`
        }
        return {
          isValid: erorMessages !== '' ? false : true,
          messages: erorMessages
        }
      }
    },
    watch: {
      selectedSite: {
        deep: true,
        async handler(siteCode, oldSiteCode) {
          if (this.isVisu) {
            this.clearData()
          } else if (!this.isVisu && siteCode && oldSiteCode !== null && oldSiteCode !== '') {
            await this.onSave(true, oldSiteCode)
          } else if (siteCode && oldSiteCode === null) {
            await this.getDataList()
          }
        }
      }
    },
    methods: {
      ...mapActions(usePrestationStore, [
        'getPrestationById',
        'setPrestationLignes',
        'setPrestation',
        'deletePrestationLigne',
        'getProforma'
      ]),
      ...mapActions(useSitesStore, [
        'getClientSites',
        'getBuList',
        'getResponsableList',
        'getServiceList'
      ]),
      ...mapActions(useRubriqueCAStore, ['getAllRubriqueCa']),
      ...mapActions(useRubriquePrestaStore, ['getAllRubriquePrestation']),
      ...mapActions(useCalendrierStore, [
        'checkPeriodIsValid',
        'getCalendrier'
      ]),
      ...mapActions(usePrestaionJustifStore, [
        'getJustificatif',
        'addJustificatif'
      ]),

      async prepareData() {
        await this.getPrestationById(this.$route.params.id)
        this.formData = {
          site_client_code:
            this.prestation.headerInfor.presta_fact_site_client_code
              .site_client_code,
          ...this.prestation.headerInfor
        }
        this.getJustificatif(this.$route.params.id)
      },
      async getDataList() {
        if (this.selectedSite !== null) {
          if (this.isCreate) {
            await this.getProforma(this.selectedSite, this.prestaDateFormat)
          }
          await this.getClientSites(this.selectedSite)
          await this.getBuList(this.selectedSite)
          await this.getResponsableList(this.selectedSite)
          await this.getServiceList(this.selectedSite)
        }
      },
      onChangeResp(val) {
        var itemSelected = this.responsableList.filter(r => {
          return r.label == val
        })
        this.formData.site_client_code = itemSelected[0].siteClientCode
        this.formData.presta_fact_numero_commande = itemSelected[0].numCommande
      },
      closeDialog() {
        this.dialogVisible = false
        this.saveData(false)
      },
      showJustificatifDialog() {
        this.isJustificatifVisible = true
      },
      getPrice(price) {
        if (price.indexOf('.') !== -1 && price.split('.')[1].length > 2) {
          // allow two decimals only
          return Math.abs(price.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0])
        }
        return price !== '' && price !== '-' ? Math.abs(price) : ''
      },
      getLineTotalHT(item) {
        if (this.isLineValid(item)) {
          return item.qte * item.price
        } else {
          return '0'
        }
      },
      getLineAutrePrestaTotalHT(item) {
        if (this.isLineValidAutresPresta(item)) {
          return item.qte * item.price
        } else {
          return '0'
        }
      },
      getLineCoutHT(item) {
        if (this.isLineValid(item)) {
          return item.qte * item.price * this.getPercentCout(item.rubriqueprest)
        } else {
          return '0'
        }
      },
      getCoutTotalHT() {
        var sumTotalHT = 0
        this.prestations.forEach(stRow => {
          if (this.isLineValid(stRow)) {
            sumTotalHT += this.getLineCoutHT(stRow)
          }
        })
        this.autrePrestations.forEach(stRow => {
          if (this.isLineValidAutresPresta(stRow)) {
            sumTotalHT += stRow.coutHt * 1
          }
        })
        return sumTotalHT
      },
      getTotalBaseTVAByTVA(tva) {
        var sumTotal = 0
        this.prestations.forEach(stRow => {
          if (this.isLineValid(stRow) && this.getTVA(stRow.ca) == tva) {
            sumTotal += this.getLineTotalHT(stRow)
          }
        })
        this.autrePrestations.forEach(stRow => {
          if (
            this.isLineValidAutresPresta(stRow) &&
            this.getTVA(stRow.ca) == tva
          ) {
            sumTotal += stRow.price * stRow.qte
          }
        })

        return sumTotal
      },
      getTotalMontantTVAByTVA(tva) {
        var sumTotal = 0
        this.prestations.forEach(stRow => {
          if (this.isLineValid(stRow) && this.getTVA(stRow.ca) == tva) {
            sumTotal +=
              this.getLineTotalHT(stRow) * (this.getTVA(stRow.ca) / 100)
          }
        })
        this.autrePrestations.forEach(stRow => {
          if (
            this.isLineValidAutresPresta(stRow) &&
            this.getTVA(stRow.ca) == tva
          ) {
            sumTotal += stRow.price * stRow.qte * (this.getTVA(stRow.ca) / 100)
          }
        })

        return sumTotal
      },
      getTotalTTCByTVA(tva) {
        return (
          this.getTotalBaseTVAByTVA(tva) + this.getTotalMontantTVAByTVA(tva)
        )
      },
      getTotalTTC() {
        // FIXME : add % TVA from rubrique CA (column ca_tva) or make sum of tableData3
        var sumTotalTTC = 0
        this.prestations.forEach(stRow => {
          if (this.isLineValid(stRow)) {
            sumTotalTTC +=
              this.getLineTotalHT(stRow) * (1 + this.getTVA(stRow.ca) / 100)
          }
        })
        this.autrePrestations.forEach(stRow => {
          if (this.isLineValidAutresPresta(stRow)) {
            sumTotalTTC +=
              stRow.price * stRow.qte * (1 + this.getTVA(stRow.ca) / 100)
          }
        })
        return sumTotalTTC
      },
      getRatioDepenseTotal() {
        if (this.getCoutTotalHT() != '')
          return (
            (this.getCoutTotalHT() * 100) /
            (this.getTotalBaseTVAByTVA(10) + this.getTotalBaseTVAByTVA(20))
          )
        return 0
      },
      isLineValid(item) {
        if (this.isBrouillon) {
          return (
            (item.ca != '' && item.ca != '-') ||
            (item.rubriqueprest != '' && item.rubriqueprest != '-') ||
            (item.prestation.length && item.prestation != '-') ||
            (item.qte != '' && item.qte != '-') ||
            (item.price != '' && item.price != '-') ||
            (item.coutHt && item.coutHt != '-')
          )
        }
        return (
          item.ca &&
          item.ca != '' &&
          item.ca != '-' &&
          item.rubriqueprest &&
          item.rubriqueprest != '' &&
          item.rubriqueprest != '-' &&
          item.prestation &&
          item.prestation.length &&
          item.prestation != '-' &&
          item.qte &&
          item.qte != '' &&
          item.qte != '-' &&
          item.price &&
          item.price != '' &&
          item.price != '-'
        )
      },
      isLineValidAutresPresta(item) {
        return (
          item.ca != '' &&
          item.rubriqueprest != '' &&
          item.prestation.length &&
          item.qte != '' &&
          item.price != ''
        )
      },
      getPercentCout(rubriqueprest) {
        var aPresta = this.rubriquesPresta.filter(i => {
          return i.value == rubriqueprest
        })
        return aPresta.length ? aPresta[0].percentCout : 1
      },
      getTVA(rubriqueca) {
        var aCA = this.rubriquesCa.filter(i => {
          return i.value == rubriqueca
        })
        return aCA.length ? aCA[0].tva : 0
      },
      async onSave(isBrouillon = false, siteCode = '') {
        this.isBrouillon = isBrouillon
        if (!isBrouillon) {
          if (!this.formValidate.isValid) {
            this.$root.$alertDialog(
              '',
              `${this.$t('prestation.alertImportXls')} <br /><br /> ${this.formValidate.messages}`
            )
          } else {
            this.dialogVisible = true
          }
        } else {
          this.saveData(isBrouillon, siteCode)
        }
      },
      async saveData(isBrouillon = false, siteCode = '') {
        // save prestation annexe
          var prestaParams = {
            enteteId: this.formData.presta_entete_id,
            prestaDate: this.prestaDateFormat,
            prestaEmail: this.formData.presta_email,
            prestaFactSiteClientCode: this.formData.site_client_code,
            prestaFactServiceNom: this.formData.presta_fact_service_nom,
            prestaFactContactNom: this.formData.presta_fact_contact_nom,
            prestaFactBu: this.formData.presta_fact_bu,
            prestaFactCodeImputation: this.formData.presta_fact_code_imputation,
            prestaFactNumeroCommande: this.formData.presta_fact_numero_commande,
            prestaX3IntegrationDate: this.formData.presta_x3_integration_date,
            prestaFactureGentationDate:
              this.formData.presta_facture_generation_date,
            prestaFactureProforma: this.formData.presta_facture_proforma,
            prestaFusionGenerationDate:
              this.formData.presta_fusion_generation_date,
            prestaCommentaire: this.formData.presta_commentaire,
            mrsSite: siteCode && siteCode !== '' ? siteCode : this.selectedSite,
            prestaStatut: isBrouillon ? 1 : 2,
            prestaProforma: this.isCreate
              ? this.proformaCode
              : this.formData.presta_proforma
          }

          await this.setPrestation(prestaParams)
            .then(async res => {
              if (res.success) {
                // save prestation liges
                const data = {
                  enteteId: this.isCreate 
                    ? res.prestaEnteteId
                    : this.prestation.headerInfor.presta_entete_id,
                  lignes: this.prestationLignes
                }
                if (this.prestationLignes.length > 0) {
                  await this.setPrestationLignes(data)
                }
                await this.uploadJustifFiles(data.enteteId)
                this.clearData()
              }
            })
      },
      async onDeleteLigne(isPrestation = true, id) {
        // remove prestation line from computed
        if (!id.toString().includes('presta')) {
          // remove prestation ligne from database
          await this.deletePrestationLigne(id)
        }
        if (isPrestation) {
          this.prestations.splice(
            this.prestations.findIndex(item => item.ligneId == id),
            1
          )
        } else {
          this.autrePrestations.splice(
            this.autrePrestations.findIndex(item => item.ligneId == id),
            1
          )
        }
      },
      async checkIfDateValid() {
        this.datePickerPrestaDate = false
        if (this.calendriers.length == 0) {
          await this.getCalendrier()
        }
        // get the current period
        const currentPeriod = this.calendriers.find(
          item => item.current == 1
        )
        // get the first period of the compatable dates
        this.prestaDateMin = this.getDateFromString(this.calendriers[this.calendriers.length - 1].calendrier_cloture_date_debut)
        this.prestaDateMax = this.getDateFromString(currentPeriod.calendrier_cloture_date_fin)
        if (!this.isVisu) {
          this.checkPeriodIsValid(this.prestaDateFormat).then(async res => {
            if (!res.isValid) {
              this.prestationDate = currentPeriod.calendrier_cloture_date_debut
            }
            if (this.isCreate) {
              await this.getProforma(this.selectedSite, this.prestaDateFormat)
            }
          })
        }
      },
      async uploadJustifFiles(prestaEnteteId) {
        this.selectedJustifFiles.forEach(async fileItem => {
          let formData = new FormData()
          formData.append('files', fileItem)
          await this.addJustificatif({
            prestaEnteteId: prestaEnteteId,
            formData
          })
        })
      },
      async clearData() {
        // clear state data
        usePrestationStore().$patch(state => {
          state.prestation.autrePrestaLignes = []
          state.prestation.prestaLignes = []
        })
        this.clearJustif()
        this.$router.push('/prestation')
      },
      clearJustif() {
        usePrestaionJustifStore().$patch(state => {
          state.prestaJustifs = []
          state.selectedJustifFiles = []
        })
      },
      getDateFromString(dateString = '') {
        if (dateString.indexOf('/') !== -1) {
          const [sDay, sMonth, sYear] = dateString.split('/')
          return new Date(sYear, sMonth - 1, sDay)
        } else {
          return dateString
        }
      }
    }
  }
</script>

<style>
  .no-hover {
    pointer-events: none;
  }

  .comment {
    width: 96%;
  }
  .custom-row {
    margin-bottom: -40px;
  }

  .custom-span {
    display: flex;
  }

  .v-field__input {
    background-color: #ffffff;
    padding-top: 3px;
    padding-bottom: 3px;
    min-height: 30px;
  }

  .v-data-table tbody tr:nth-child(even) {
    background-color: #ecf2ff;
  }

  .v-input__control {
    background-color: #ffffff;
    margin-bottom: -15px;
  }

  .v-data-table tbody tr:nth-child(odd) {
    background-color: #ffffff;
  }

  .v-text-field__suffix {
    opacity: 1;
    padding-top: 3px;
    padding-bottom: 3px;
    min-height: 30px;
  }
</style>

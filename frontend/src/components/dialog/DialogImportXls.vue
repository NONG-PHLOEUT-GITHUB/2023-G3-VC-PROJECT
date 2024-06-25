<template>
  <v-dialog v-model="dialog" width="350px" style="z-index: 999">
    <!-- Dialog content -->
    <v-card class="rounded bg-dialog">
      <v-card-text
        align="center"
        style="font-size: 12px"
        class="font-weight-bold"
      >
        Importer votre bon de livraison Excel en ajoutant votre fichier
      </v-card-text>
      <v-card variant="text" class="mx-auto mt-4" width="80%">
        <v-file-input
          v-model="file"
          density="compact"
          variant="outlined"
          @change="handleFileUpload"
        ></v-file-input>
      </v-card>
      <v-card-actions class="d-flex justify-space-between">
        <v-btn
          class="font-weight-bold px-6 ml-6 annuler"
          style="font-size: 12px; height: 30px"
          variant="outlined"
          @click="closeDialog"
        >
          {{ $t(`btn.annuler`) }}
        </v-btn>
        <v-btn
          class="font-weight-bold mr-6 px-6 enregistrer"
          variant="flat"
          style="font-size: 12px; height: 30px"
          @click="goto"
        >
          {{ $t(`btn.enregistrer`) }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
  import { mapActions, mapState } from 'pinia'
  import { usePrestationStore } from '@/stores/prestation'

  export default {
    props: {
      importDialog: { required: true, type: Boolean }
    },
    data() {
      return {
        file: null,
        isError: false,
        messageEror: null
      }
    },
    computed: {
      ...mapState(usePrestationStore, [
        'itemsExcel',
        'prestaLignes',
        'autrePrestaLignes'
      ]),
      dialog: {
        get() {
          return this.importDialog
        },
        set(value) {
          this.$emit('update:importDialog', value)
        }
      }
    },
    methods: {
      ...mapActions(usePrestationStore, ['uploadExcelFile']),
      closeDialog() {
        this.dialog = false
      },
      goto() {
        if (this.itemsExcel) {
          this.$router.push({
            path: '/prestation/edit',
            query: {
              generainfo: JSON.stringify(this.itemsExcel),
              prestaLignes: JSON.stringify(this.prestaLignes),
              autrePrestaLignes: JSON.stringify(this.autrePrestaLignes)
            }
          })
        }
      },
      async handleFileUpload(event) {
        let xlsxfile = event.target.files ? event.target.files[0] : null

        if (!xlsxfile) return

        const formData = new FormData()
        formData.append('file', xlsxfile)

        this.messageEror = await this.uploadExcelFile(formData)
        if (this.messageEror.success === false) {
          //Custom alert dialog to show error message
          this.$root.$alertDialog(
            '',
            `${this.$t('prestation.alertImportXls')} <br /><br /> ${this.messageEror.message}`,
            '',
            `/prestation/edit`,
            
          )
        }
      }
    }
  }
</script>
<style scoped></style>

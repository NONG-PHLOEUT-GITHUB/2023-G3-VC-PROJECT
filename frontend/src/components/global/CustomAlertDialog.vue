<template>
  <v-dialog v-model="dialog" width="auto">
    <v-card class="bg-dialog" max-width="350">
      <v-card-item v-if="options.errorType == 'login'">
        <v-row class="pa-4">
          <v-col cols="6" class="d-flex align-end justify-end">
            <h1>{{ title }}</h1>
          </v-col>
          <v-col style="margin-left: -60px">
            <v-icon size="80" class="color-error">mdi-alert-rhombus</v-icon>
          </v-col>
          <span
            class="font-weight-bold"
            style="font-size: 12px"
            v-html="message"
          ></span>
          <v-col class="text-center">
            <v-btn
              :text="$t('btn.fermer')"
              :to="path"
              variant="tonal"
              max-height="30px"
              class="bg-primary px-5 mt-1"
              @click="dialog = false"
            ></v-btn>
          </v-col>
        </v-row>
      </v-card-item>
      <v-card-item v-else>
        <v-card-title class="mb-4">
          <strong>{{ title }}</strong>
        </v-card-title>
        <span v-html="message"></span>
        <v-card-text class="text-center">
          <v-icon size="80" class="color-error">mdi-lock-alert</v-icon>
        </v-card-text>
      </v-card-item>
    </v-card>
  </v-dialog>
</template>

<script>
  import { mapState } from 'pinia'
  import { usePrestationStore } from '@/stores/prestation'
  export default {
    name: 'ConfirmDialog',
    data() {
      return {
        dialog: false,
        title: '',
        message: '',
        path: {},
        options: {}
      }
    },
    computed: {
      ...mapState(usePrestationStore, [
        'itemsExcel',
        'prestaLignes',
        'autrePrestaLignes'
      ])
    },
    methods: {
      showAlert(title, message, options, path) {
        this.dialog = true
        this.title = title
        this.message = message
        this.path = Object.assign({
          path: path,
          query: {
            generainfo: JSON.stringify(this.itemsExcel),
            prestaLignes: JSON.stringify(this.prestaLignes),
            autrePrestaLignes: JSON.stringify(this.autrePrestaLignes)
          }
        })
        this.options = Object.assign(
          {
            errorType: 'login'
          },
          options
        )
      }
    }
  }
</script>

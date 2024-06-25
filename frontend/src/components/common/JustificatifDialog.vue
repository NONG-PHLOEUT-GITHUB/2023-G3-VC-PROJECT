<template>
  <v-dialog width="400" style="font-size: 12px;" v-model="localVisible">
    <v-card class="rounded bg-dialog pa-1 px-8">
      <v-card-text class="font-weight-bold" align="center">
        {{ $t('title.importJustif') }}
      </v-card-text>
      <v-card-subtitle class="font-italic text-center">
        {{ $t('title.uniquePdf') }}
      </v-card-subtitle>
      <v-card class="d-flex flex-column" variant="text">
        <!-- Card content goes here -->
        <div v-for="(file, index) in selectedFiles" :key="index">
          <v-row class="ma-0">
            <v-col cols="1" />
            <v-col cols="8">
              <span>{{ file.name || file.origineFilename }}</span>
            </v-col>
            <v-col cols="3">
              <v-btn
                variant="text"
                class="blue-text"
                size="small"
                icon="mdi-file-search-outline"
                density="compact"
                @click="onPrintJustificatif(file)"
              />
              <v-btn
                v-if="!isVisu"
                variant="text"
                size="small"
                icon="mdi-delete-empty"
                density="compact"
                class="ml-1 color-error"
                @click="onDeleteFile(index, file)"
              />
            </v-col>
          </v-row>
        </div>
      </v-card>

      <v-card v-if="!isVisu" variant="text" class="mx-auto mt-6" width="280px" height="50px">
        <v-file-input
          prepend-icon="mdi-paperclip"
          v-model="files"
          density="compact"
          :rules="rules"
          accept=".pdf"
          variant="outlined"
          :multiple="false"
          flat
          hide-details
        />
      </v-card>
      <v-card-actions class="d-flex justify-center mt-4">
        <v-btn
          class="btn enregistrer"
          width="50%"
          height="32px"
          variant="flat"
          @click="closeDialog"
        >
          {{ $t(`btn.fermer`) }}
        </v-btn>
        <v-btn
          v-if="!isVisu"
          width="50%"
          height="32px"
          class="btn enregistrer"
          variant="flat"
          @click="handleFileUpload"
        >
          {{ $t(`btn.importer`) }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
  import { mapActions, mapState } from 'pinia'
  import { usePrestaionJustifStore } from '../../stores/prestationJustif'
  export default {
    props: {
      modelValue: {
        type: Boolean,
        default: false
      },
      isVisu: {
        type: Boolean,
        required: false,
        default: false
      }
    },

    data() {
      return {
        justicatif: false,
        files: [],
        localVisible: this.modelValue,
        rules: [
          value =>
            value.length === 0 ||
            value[0].type.toLowerCase() === 'application/pdf' ||
            this.$t('rules.uniquePdf')
        ]
      }
    },
    watch: {
      modelValue(newVal) {
        this.localVisible = newVal
      },
      localVisible(newVal) {
        if (!newVal) {
          this.$emit('update:visible', false)
          this.$emit('update:modelValue', false)
        }
      }
    },
    computed: {
      ...mapState(usePrestaionJustifStore, [
        'prestaJustifs',
        'selectedJustifFiles'
      ]),

      selectedFiles() {
        return this.prestaJustifs.concat(this.selectedJustifFiles)
      }
    },
    methods: {
      ...mapActions(usePrestaionJustifStore, [
        'getJustificatif',
        'deleteJustificatif',
        'printJustificatif'
      ]),

      closeDialog() {
        this.localVisible = false
      },
      async handleFileUpload() {
        if (this.files.length > 0) {
          this.selectedJustifFiles.push(this.files[0])
          this.files = []
        }
      },
      onDeleteFile(indexItem, file) {
        if (file.justifId) {
          // remove file from server
          this.deleteJustificatif(file.justifId).then(res => {
            if (res.success) {
              this.prestaJustifs.splice(indexItem, 1)
            }
          })
        } else {
          // remove local file
          const localIndex = this.selectedJustifFiles.indexOf(file)
          this.selectedJustifFiles.splice(localIndex, 1)
        }
      },
      async onPrintJustificatif(file) {
        let blob = null
        const link = document.createElement('a')
        if (file.justifId) {
          // download file from server
          await this.printJustificatif(file.justifId).then(res => {
            blob = new Blob([res], {
              type: 'application/pdf',
              encoding: 'UTF-8'
            })
            link.download = file.origineFilename
          })
        } else {
          // download local file
          blob = new Blob([file], {
            type: 'application/pdf',
            encoding: 'UTF-8'
          })
          link.download = file.name
        }
        link.href = window.URL.createObjectURL(blob)
        link.click()
      }
    }
  }
</script>
<style>
</style>

<template>
    <v-dialog v-model="dialog" :max-width="options.width" @keydown.esc="cancel">
      <v-card>
        <v-card-title class="bg-red">
          <!-- <v-toolbar :color="bgColor" dense elevation="0">
            <v-toolbar-title :class="'text-capitalize title ' + textColor"> -->
            <strong> {{ title }}</strong> 
            <!-- </v-toolbar-title>
          </v-toolbar> -->
        </v-card-title>
        <v-card-text
          v-show="!!message"
          class="capitalize-first-letter pt-6 pb-4"
          v-html="message"
        />
        <v-card-actions class="pa-4">
          <v-spacer />
          <v-btn
            elevation="0"
            ref="btnNo"
            @click.native="cancel"
            variant="outlined"
          >
          {{ $t('btn.cancel') }}
            <!-- {{ options.denyBtnText }} -->
          </v-btn>
          <v-btn
            elevation="0"
            class="bg-red"
            @click.native="agree"
          >
          {{ $t('btn.yes') }}
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </template>
  
  <script>
  export default {
    name: 'ConfirmDialog',
    data() {
      return {
        dialog: false,
        agreeCallback: null,
        cancelCallback: null,
        message: null,
        title: null,
        options: {
          type: 'error',
          width: 290,
          agreeBtnText: this.$t('btn.delete'),
          denyBtnText: this.$t('btn.cancel'),
        },
      }
    },
    computed: {
      bgColor() {
        const colors = {
          info: '#233F740F',
          error: '#FF52520F',
          warning: '#FFC1070F',
        }
  
        return colors[this.options.type || 'info']
      },
      textColor() {
        const colors = {
          info: 'primary--text',
          error: 'error--text',
          warning: 'warning--text',
        }
  
        return colors[this.options.type || 'info']
      },
      btnColor() {
        const colors = {
          info: 'var(--v-primary-base)',
          error: 'var(--v-error-base)',
          warning: 'var(--v-warning-base)',
        }
  
        return colors[this.options.type || 'info']
      },
    },
    methods: {
      open({ title, message, options, agree = () => {}, cancel = () => {} }) {
        this.dialog = true
        this.title = title
        this.message = message
        this.options = Object.assign(this.options, options)
        this.agreeCallback = agree
        this.cancelCallback = cancel
      },
      async agree() {
        await this.agreeCallback()
        this.dialog = false
      },
      async cancel() {
        await this.cancelCallback()
        this.dialog = false
      },
    },
  }
  </script>
  
  <style scoped>
  .title {
    font-size: 1rem !important;
  }
  .cancel-btn {
    background: transparent !important;
  }
  .cancel-btn.btn-info {
    border: 1px solid var(--v-primary-base);
    color: var(--v-primary-base);
  }
  .cancel-btn.btn-error {
    border: 1px solid var(--v-error-base);
    color: var(--v-error-base);
  }
  </style>
  
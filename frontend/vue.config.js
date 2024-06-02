const { defineConfig } = require('@vue/cli-service')

module.exports = defineConfig({
  transpileDependencies: true,
  lintOnSave: false,
  pluginOptions: {
    i18n: {
      locale: 'en', // process.env.VUE_APP_I18N_LOCALE
      fallbackLocale: 'en',
      localeDir: 'locales',
      enableInSFC: false,
      enableBridge: false,
    },
    
    vuetify: {
      // Configure Vuetify plugin options
      // Replace 'MyLoginComponent' with your desired multi-word component name
      customVariables: ['~/assets/variables.scss'],
      theme: {
        dark: true,
      },
      optionsPath: './vuetify.options.js',
      // Specify multi-word component name for Vuetify
      // Change 'Login' to a multi-word component name like 'MyLoginComponent'
      multiWordComponentName: false,
    },
  },
})

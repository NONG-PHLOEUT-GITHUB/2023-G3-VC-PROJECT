const { defineConfig } = require('@vue/cli-service')

module.exports = defineConfig({
  transpileDependencies: true,
  lintOnSave: false,
  pluginOptions: {
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

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify'
import { loadFonts } from './plugins/webfontloader'
import CreateUserForm from './views/Dashboard/CreateUserForm.vue'

loadFonts()
const app = createApp(App)
app.component('create-user-form' , CreateUserForm)
app
  .use(router)
  .use(vuetify)
  .mount('#app')

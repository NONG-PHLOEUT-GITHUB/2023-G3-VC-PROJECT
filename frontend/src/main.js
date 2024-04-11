import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify'

//global components

import CustomTitle from './components/global/CustomTitle.vue'
import CustomSubTitle from './components/global/CustomSubTitle.vue'

const app = createApp(App)
const pinia = createPinia();

app.component('custom-title',CustomTitle)
app.component('custom-sub-title',CustomSubTitle)

app.use(pinia)
app.use(router)
app.use(vuetify)
app.mount('#app')

import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import { fr, en } from 'vuetify/locale'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import * as labs from 'vuetify/labs/components'
import { VDateInput } from 'vuetify/labs/VDateInput'

const vuetify = createVuetify({
  components: {
    VDateInput,
    ...components,
    ...labs
  },
  directives,
  theme: {
    themes: {
      light: {
        dark: false,
      },
    },
  },
  locale: {
    messages: { fr, en },
    locale: 'en'
  },
  icons: {
    iconfont: 'mdi'
  },
  date: {
    locale: {
      en: 'en-GB'
    }
  }
})

export default vuetify

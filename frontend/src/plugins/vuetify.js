import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import { fr, en } from 'vuetify/locale'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import * as labs from 'vuetify/labs/components'
import { VDateInput } from 'vuetify/labs/VDateInput'
import colors from 'vuetify/util/colors'

const myCustomLightTheme = {
  dark: false,
  colors: {
    background: '#FFFFFF',
    surface: '#FFFFFF',
    'surface-bright': '#FFFFFF',
    'surface-light': '#EEEEEE',
    'surface-variant': '#424242',
    'on-surface-variant': '#EEEEEE',
    primary: '#a3e635',
    'primary-darken-1': '#1F5592',
    secondary: '#48A9A6',
    'secondary-darken-1': '#018786',
    error: '#B00020',
    info: '#2196F3',
    success: '#4CAF50',
    warning: '#FB8C00',
    something: 'red',
  },
  variables: {
    'border-color': '#000000',
    'border-opacity': 0.12,
    'high-emphasis-opacity': 0.87,
    'medium-emphasis-opacity': 0.60,
    'disabled-opacity': 0.38,
    'idle-opacity': 0.04,
    'hover-opacity': 0.04,
    'focus-opacity': 0.12,
    'selected-opacity': 0.08,
    'activated-opacity': 0.12,
    'pressed-opacity': 0.12,
    'dragged-opacity': 0.08,
    'theme-kbd': '#212529',
    'theme-on-kbd': '#FFFFFF',
    'theme-code': '#F5F5F5',
    'theme-on-code': '#000000',
  }
}

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
        colors: {
          primary: '#89474b', // #E53935
          secondary: "#c17290", // #FFCDD2
          textField: "#ab5777", // #FFCDD2
          icon: "#653748", // #FFCDD2
          btnEdit: "#a0627f", // #FFCDD2
          // card: "#be4054", // #FFCDD2
        }
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

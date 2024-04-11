import "@mdi/font/css/materialdesignicons.css";
import "vuetify/styles";
import { createVuetify } from "vuetify";
import { fr, en } from "vuetify/locale";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import * as labs from "vuetify/labs/components";

const vuetify = createVuetify({
  components: {
    ...components,
    ...labs,
  },
  directives,
  theme: {
    options: {
      customProperties: true,
    },
    themes: {
      light: {
        primary: "#043485",
        accent: "#E00D1D",
      },
    },
  },
  locale: {
    messages: { fr, en },
    locale: "en",
  },
  icons: {
    iconfont: "mdi",
  },
});

export default vuetify;

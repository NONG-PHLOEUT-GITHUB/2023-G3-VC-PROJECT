import { createI18n } from 'vue-i18n';

const dateTimeFormats = {
  fr: {
    date: {
      year: 'numeric',
      month: 'numeric',
      day: 'numeric'
    },
    datetime: {
      year: 'numeric',
      month: 'numeric',
      day: 'numeric',
      hour: 'numeric',
      minute: 'numeric',
      hour12: false
    },
    short: {
      month: 'numeric',
      day: 'numeric'
    },
    long: {
      year: 'numeric',
      month: 'short',
      day: 'numeric',
      weekday: 'short',
      hour: 'numeric',
      minute: 'numeric'
    },
    monthYear: {
      year: 'numeric',
      month: 'short'
    }
  }
};

function loadLocaleMessages() {
  const locales = require.context('@/locales', true, /[A-Za-z0-9-_,\s]+\.json$/i);
  const messages = {};
  locales.keys().forEach(key => {
    const matched = key.match(/([A-Za-z0-9-_]+)\./i);
    if (matched && matched.length > 1) {
      const locale = matched[1];
      messages[locale] = locales(key);
    }
  });
  return messages;
}

const i18n = createI18n({
  legacy: false, // for Vue 3, set to false
  locale: process.env.VUE_APP_I18N_LOCALE || 'en',
  fallbackLocale: process.env.VUE_APP_I18N_FALLBACK_LOCALE || 'en',
  messages: loadLocaleMessages(),
  dateTimeFormats
});

export function translateRoute(routeName) {
  return i18n.global.t(routeName);
}

export default i18n;

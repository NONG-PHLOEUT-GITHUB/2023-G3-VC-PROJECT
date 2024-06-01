import { nextTick } from 'vue'
import { createI18n } from 'vue-i18n'

let i18n

export const SUPPORT_LOCALES = ['en', 'kh']

export function setI18nLanguage(locale) {
  loadLocaleMessages(locale)

  if (i18n.mode === 'legacy') {
    i18n.global.locale = locale
  } else {
    i18n.global.locale.value = locale
  }

  document.querySelector('html').setAttribute('lang', locale)
  localStorage.setItem('lang', locale)
}

export async function loadLocaleMessages(locale) {
  // load locale messages with dynamic import
  const messages = await import(
    /* webpackChunkName: "locale-[request]" */ `../locales/${locale}.json`
  )

  // set locale and locale message
  i18n.global.setLocaleMessage(locale, messages.default)

  return nextTick()
}

export default function setupI18n() {
  if (!i18n) {
    let locale = localStorage.getItem('lang') || 'en'

    i18n = createI18n({
      globalInjection: true,
      legacy: false,
      locale: process.env.VUE_APP_I18N || "en",
      fallbackLocale: process.env.VUE_APP_I18N_FALLBACK_LOCALE || "en",
    })

    setI18nLanguage(locale)
  }
  return i18n
}
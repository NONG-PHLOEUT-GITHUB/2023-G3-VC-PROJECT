<template>
  <v-menu min-width="200px" rounded>
    <template v-slot:activator="{ props }">
      <v-btn v-bind="props" stacked>
        <v-avatar color="brown" size="small">
          <v-img :src="currentLanguageImage" :width="30"></v-img>
        </v-avatar>
      </v-btn>
    </template>
    <v-list nav density="compact">
      <v-list-item
        v-for="list in orderedLanguage"
        :key="list.lang"
        @click="switchLanguage(list.lang)"
      >
        <template v-slot:append>
          <v-avatar size="small">
            <v-img :src="list.imgSrc" :alt="list.alt" cover />
          </v-avatar>
        </template>
        <v-list-item-title v-text="list.label"></v-list-item-title>
      </v-list-item>
    </v-list>
  </v-menu>
</template>

<script>
  export default {
    methods: {
      switchLanguage(lang) {
        this.$i18n.locale = lang
        localStorage.setItem('lang', lang)
      }
    },
    computed: {
      currentLanguageImage() {
        return this.$i18n.locale === 'en' ? '/images/en.png' : '/images/kh.png'
      },
      orderedLanguage() {
        const buttons = [
          {
            lang: 'en',
            imgSrc: '/images/en.png',
            alt: 'English Flag',
            label: this.$t('lang.en')
          },
          {
            lang: 'kh',
            imgSrc: '/images/kh.png',
            alt: 'Khmer Flag',
            label: this.$t('lang.kh')
          }
        ]

        // Position the current language button second
        return buttons.sort((a, b) => {
          if (a.lang === this.$i18n.locale) return 1
          if (b.lang === this.$i18n.locale) return -1
          return 0
        })
      }
    },
    created() {
      const lang = localStorage.getItem('lang')
      if (lang) {
        this.$i18n.locale = lang
      }
    }
  }
</script>

<template>
	<v-menu min-width="200px" rounded>
		<template v-slot:activator="{ props }">
			<v-btn v-bind="props" stacked>
				<v-avatar color="brown" size="small">
					<v-img :src="currentLanguageImage" :width="30"></v-img>
				</v-avatar>
			</v-btn>
		</template>
		<v-card class="pa-0">
			<v-card-text class="pa-2">
				<div class="mx-auto">
					<v-btn
						@click="switchLanguage('en')"
						variant="text"
						rounded
						class="text-none"
					>
						<img
							src="/images/en.png"
							alt="English Flag"
							:width="30"
							class="me-3"
						/>
						{{ $t('lang.en') }}
					</v-btn>
					<v-btn
						@click="switchLanguage('kh')"
						variant="text"
						rounded
						class="text-none"
					>
						<img
							src="/images/kh.png"
							alt="Khmer Flag"
							:width="30"
							class="me-3"
						/>
						{{ $t('lang.kh') }}
					</v-btn>
				</div>
			</v-card-text>
		</v-card>
	</v-menu>
</template>

<script>
export default {
	methods: {
		switchLanguage(lang) {
			// Assuming you are using VueI18n, you can set the locale using this.$i18n.locale
			this.$i18n.locale = lang
			localStorage.setItem('lang', lang)
		}
	},
	computed: {
		currentLanguageImage() {
			// Assuming you have a computed property to determine the current language image path
			// Replace 'en.png' and 'kh.png' with the actual file names of your language flags
			return this.$i18n.locale === 'en' ? '/images/en.png' : '/images/kh.png'
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

<template>
  <v-app-bar>
    <v-app-bar-nav-icon @click="togglerDrawer">
      <v-icon>mdi-menu</v-icon>
    </v-app-bar-nav-icon>
    <strong class="text-h6 font-weight-bold">{{ $t('titleApp') }}</strong>
    <!-- switcher language -->
    <template v-slot:append>
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
              <v-btn @click="switchLanguage('en')" variant="text" rounded class="text-none">
                <img src="/images/en.png" alt="English Flag" :width="30" class="me-3"/>
                {{$t('lang.en')}}
              </v-btn>
              <v-btn @click="switchLanguage('kh')" variant="text" rounded class="text-none">
                <img src="/images/kh.png" alt="Khmer Flag" :width="30" class="me-3"/>
                {{$t('lang.kh')}}
              </v-btn>
            </div>
          </v-card-text>
        </v-card>
      </v-menu>
      <!-- notification -->
      <v-btn class="text-none" stacked>
        <!-- v-bind="props" -->
        <v-badge class="mt-2" content="2" color="error">
          <v-icon class="cursor-pointer">mdi-bell-outline</v-icon>
        </v-badge>
      </v-btn>
      <!-- menu setting -->
      <v-menu rounded>
        <template v-slot:activator="{ props }">
          <strong class="me-6">{{ authUser.first_name }} {{ authUser.last_name }}</strong>
          <v-btn icon="" v-bind="props" class="me-2">
            <v-avatar color="brown" size="large" class="avatar">
              <v-img :src="authUser.profile" alt="Avatar" cover> </v-img>
            </v-avatar>
          </v-btn>
        </template>
        <v-list>
          <v-list-item>
            <v-avatar size="large" class="avatar">
              <v-img :src="authUser.profile" alt="Avatar" cover> </v-img>
            </v-avatar>
            <strong class="ms-2">
              {{ abbreviatedName }}
            </strong>
          </v-list-item>

          <v-col cols="auto">
            <v-btn size="small" block variant="outlined" color="primary" to="/user-profile">
              <strong> {{ $t('btn.viewProfile') }}</strong>
            </v-btn>
          </v-col>
          <v-list-item
            v-for="(item, i) in menus"
            :key="i"
            :value="item"
            color="primary"
            @click="onMenuClick(item.action)"
          >
            <template v-slot:prepend>
              <v-icon size="large" class="icon-setting" :icon="item.icon"></v-icon>
              <v-list-item-title
                class="ms-3"
                v-text="item.title"
                :to="item.path"
              ></v-list-item-title>
            </template>
          </v-list-item>
        </v-list>
      </v-menu>
    </template>
  </v-app-bar>

  <v-dialog v-model="dialogVisible" transition="dialog-top-transition" width="auto">
    <change-password-dialog
      @cancel="dialogVisible = false"
      @password-changed="dialogVisible = false"
    />
  </v-dialog>
</template>

<script>
import ChangePasswordDialog from '@/views/auth/ChangePassword.vue'
import Sidebar from './Sidebar.vue'
import Language from '@/components/common/SwitcherLanguage.vue'
import { setI18nLanguage, SUPPORT_LOCALES } from '@/plugins/i18n'

import { mapActions, mapState } from 'pinia'
import { useAuthStore } from '@/stores/auth'
export default {
  props: ['menubar'],
  name: 'LayoutDashboard',
  emits: ['toggle'],

  components: {
    ChangePasswordDialog,
    Sidebar,
    Language
  },
  data: () => ({
    users: [],
    dialogVisible: false,
    first_name: '',
    last_name: '',
    profile_image: '',
    email: '',
    currentLanguage: localStorage.getItem('lang') || 'en',
    languageImages: {
      en: '/images/en.png',
      kh: '/images/kh.png'
    },
    menus: [
      {
        title: 'Change Password',
        action: 'changePassword',
        icon: 'mdi-lock-reset'
      },
      {
        title: 'Logout',
        icon: 'mdi-logout',
        action: 'logout'
      }
    ]
  }),
  created() {
    this.fetchUser()
  },
  computed: {
    ...mapState(useAuthStore, ['authUser']),
    abbreviatedName() {
      const fullName = `${this.authUser.first_name} ${this.authUser.last_name}`
      if (fullName.length > 15) {
        return fullName.substring(0, 15) + '...'
      } else {
        return fullName
      }
    },
    currentLanguageImage() {
      return this.languageImages[this.currentLanguage]
    }
  },
  methods: {
    ...mapActions(useAuthStore, ['logout', 'fetchUser']),
    logoutUser() {
      this.logout().then(response => {
        if (response.status === 200) {
          this.$router.push('/login')
          localStorage.removeItem('access_token')
          localStorage.removeItem('user_role')
          this.$root.$notif('Logout successfully', {
            type: 'success',
            color: 'primary'
          })
        }
      })
    },
    togglerDrawer() {
      this.$emit('toggle')
    },
    onMenuClick(action) {
      switch (action) {
        case 'logout':
          this.logoutUser()
          break
        case 'changePassword':
          this.dialogVisible = true
          break
        default:
          break
      }
    },
    async switchLanguage(language) {
      if (SUPPORT_LOCALES.includes(language)) {
        await setI18nLanguage(language)
        this.currentLanguage = language
      }
    }
  }
}
</script>
<style scoped>
.avatar {
  border: solid rgb(105, 208, 208);
}
.font-weight-black {
  text-transform: uppercase;
}
/* .v-list-item-title{
  font-weight: bold;
  text-transform: uppercase;
} */
</style>

<template>
  <v-app-bar scroll-behavior="inverted">
    <v-app-bar-nav-icon @click="togglerDrawer">
      <v-icon>mdi-menu</v-icon>
    </v-app-bar-nav-icon>
    <strong class="font-weight-bold d-none d-lg-block d-print-block">
      {{ $t('titleApp') }}
    </strong>
    <template v-slot:append>
      <!-- switcher language -->
      <switch-language />
      <!-- notification -->
      <v-btn class="text-none" stacked>
        <!-- v-bind="props" -->
        <v-badge class="mt-2" content="2" color="error">
          <v-icon class="cursor-pointer">mdi-bell-outline</v-icon>
        </v-badge>
      </v-btn>
      <v-btn stacked>
        <v-switch
          inset
          color="secondary"
          v-model="darkMode"
          @change="toggleTheme"
          hide-details
          false-icon="mdi-theme-light-dark"
          true-icon="mdi-theme-light-dark"
        ></v-switch>
      </v-btn>
      <!-- menu setting -->
      <v-menu>
        <template v-slot:activator="{ props }">
          <span class="me-1 d-none d-lg-block d-print-block">
            {{ authUser.first_name }} {{ authUser.last_name }}
          </span>
          <v-btn v-bind="props" class="me-1" stacked>
            <v-avatar color="brown" size="large" class="avatar">
              <v-img :src="authUser.profile" alt="Avatar" cover></v-img>
            </v-avatar>
          </v-btn>
        </template>
        <v-list>
          <!-- density="compact" nav -->
          <v-list-item>
            <v-list-item-title>
              <strong>{{ abbreviatedName }}</strong>
            </v-list-item-title>
            <v-list-item-subtitle>{{ abbreviatedEmail }}</v-list-item-subtitle>
            <template v-slot:prepend>
              <v-avatar size="large" class="avatar" color="grey-lighten-1">
                <v-img :src="authUser.profile" alt="Avatar" cover></v-img>
              </v-avatar>
            </template>
          </v-list-item>

          <v-col cols="auto">
            <v-btn
              size="small"
              block
              variant="outlined"
              color="primary"
              to="/user-profile"
            >
              <strong>{{ $t('btn.viewProfile') }}</strong>
            </v-btn>
          </v-col>
          <v-list-item
            v-for="(item, i) in menus"
            :key="i"
            :value="item"
            color="primary"
            @click="onMenuClick(item.action)"
          >
            <template v-slot:append>
              <v-icon
                size="large"
                :icon="item.icon"
                color="primary"
              ></v-icon>
            </template>
            <v-list-item-title v-text="item.title"></v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </template>
  </v-app-bar>

  <v-dialog
    v-model="dialogVisible"
    transition="dialog-top-transition"
    width="auto"
  >
    <change-password-dialog
      @cancel="dialogVisible = false"
      @password-changed="dialogVisible = false"
    />
  </v-dialog>
</template>

<script>
  import ChangePasswordDialog from '@/views/auth/ChangePassword.vue'
  import Sidebar from './Sidebar.vue'
  import switchLanguage from '@/components/common/SwitcherLanguage.vue'
  import { mapActions, mapState } from 'pinia'
  import { useAuthStore } from '@/stores/auth'
  import { useTheme } from 'vuetify'

  export default {
    props: ['menubar'],
    name: 'LayoutDashboard',
    emits: ['toggle'],

    components: {
      ChangePasswordDialog,
      Sidebar,
      switchLanguage
    },
    data: () => ({
      users: [],
      dialogVisible: false,
      first_name: '',
      last_name: '',
      profile_image: '',
      email: '',
      darkMode: false
    }),
    setup() {
      const theme = useTheme()
      return { theme }
    },
    created() {
      this.fetchUser()
      // Retrieve theme preference from localStorage
      const savedTheme = localStorage.getItem('theme')
      if (savedTheme !== null) {
        this.darkMode = JSON.parse(savedTheme)
      } else {
        this.darkMode = false // Default to light theme if no preference is saved
      }

      // Set the initial theme
      this.toggleTheme()
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
      abbreviatedEmail() {
        const email = `${this.authUser.email}`
        if (email.length > 15) {
          return email.substring(0, 15) + '...'
        } else {
          return email
        }
      },
      menus() {
        return [
          {
            action: 'changePassword',
            title: this.$t('header.changePass'),
            icon: 'mdi-lock-reset'
          },
          {
            title: this.$t('header.logout'),
            icon: 'mdi-logout',
            action: 'logout'
          }
        ]
      }
    },
    methods: {
      ...mapActions(useAuthStore, ['logout', 'fetchUser']),
      logoutUser() {
        this.$root.$confirm({
          title: 'Are you sure?',
          message: 'Are you sure you want to logout?',
          options: {
            agreeBtnText: 'Yes',
            type: 'error',
            color: 'error',
            width: 400
          },
          agree: () =>
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
        })
      },
      togglerDrawer() {
        this.$emit('toggle')
      },
      toggleTheme() {
        this.theme.global.name.value = this.darkMode ? 'dark' : 'light'
        localStorage.setItem('theme', JSON.stringify(this.darkMode))
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
      }
    }
  }
</script>
<style scoped>
  .avatar {
    border: solid #89474b;
  }
  .font-weight-bold {
    font-size: 1.25rem;
  }
</style>

<template>
  <v-app-bar>
    <v-app-bar-nav-icon @click="togglerDrawer">
      <v-icon>mdi-menu</v-icon>
    </v-app-bar-nav-icon>
    <v-title>School Management</v-title>
    <v-spacer />
    <div>
      <v-list-item class="px-2">
        <v-menu rounded>
          <template v-slot:activator="{ props }">
            <strong class="me-6">Nong Phloeut</strong>
            <v-btn icon v-bind="props" class="me-5">
              <v-avatar color="" size="large">
                <v-img
                  src="https://a.storyblok.com/f/191576/1200x800/215e59568f/round_profil_picture_after_.webp"
                  alt="Avatar"
                  cover
                >
                </v-img>
              </v-avatar>
            </v-btn>
          </template>

          <v-list>
            <v-list-item>
              <div class="profile">
                <v-avatar color="" size="large">
                  <v-img
                    src="https://a.storyblok.com/f/191576/1200x800/215e59568f/round_profil_picture_after_.webp"
                    alt="Avatar"
                    cover
                  >
                  </v-img>
                </v-avatar>
                <!-- <div class="subtitle" v-for="(value, key) in authStore.user" :key="key">
                      <span class="font-weight-black">
                        {{ value.first_name }}
                        {{ value.last_name }}
                      </span>
                      <br />
                      <span class="email">{{ value.email }}</span>
                    </div> -->
                <!-- <span>nongphloeut@gmail.com</span> -->
              </div>
            </v-list-item>

            <v-col cols="auto">
              <v-btn size="small" block variant="outlined" color="primary" to="/user-profile"
                >user profile</v-btn
              >
            </v-col>
            <v-divider></v-divider>
            <v-list-item
              v-for="(item, i) in menus"
              :key="i"
              :value="item"
              color="primary"
              @click="onMenuClick(item.action)"
            >
              <template v-slot:prepend>
                <v-icon size="large" class="icon-setting" :icon="item.icon"></v-icon>
                <v-list-item-title v-text="item.title" :to="item.path"></v-list-item-title>
              </template>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-list-item>
    </div>
  </v-app-bar>

  <v-dialog v-model="dialogVisible" transition="dialog-top-transition" width="auto">
    <change-password-dialog
      @cancel="dialogVisible = false"
      @password-changed="dialogVisible = false"
    />
  </v-dialog>
</template>

<script>
// https://snyk.io/advisor/npm-package/lru-cache/functions/lru-cache
import http from '@/api/api'
import Cookies from 'js-cookie'
import ChangePasswordDialog from '@/views/auth/ChangePassword.vue'
import LRU from 'lru-cache'
import Sidebar from './Sidebar.vue'
const cache = new LRU(100)

export default {
  props: ['menubar'],
  name: 'LayoutDashboard',

  components: {
    ChangePasswordDialog,
    Sidebar
  },
  data: () => ({
    users: [],
    dialogVisible: false,
    menus: [
      {
        title: 'change password',
        action: 'changePassword',
        icon: 'mdi-lock-reset'
      },
      {
        title: 'logout',
        icon: 'mdi-logout',
        action: 'logout'
      }
    ]
  }),

  methods: {
    async fetchData() {
      const cachedResponse = cache.get('users')

      if (cachedResponse) {
        this.users = cachedResponse
        return
      }

      try {
        const response = await http.get('/user')
        this.users = response.data.data
        cache.set('users', this.users)
      } catch (error) {
        console.error(error)
      }
    },

    logout() {
      http
        .post(
          '/v1/auth/logout',
          {},
          {
            headers: {
              Authorization: 'Bearer ' + localStorage.getItem('access_token')
            }
          }
        )
        .then(() => {})
        .then(result => {
          if (result.isConfirmed) {
            Cookies.remove('access_token')
            Cookies.remove('user_role')
            this.$router.push('/login')
          }
        })

        .catch(error => {
          console.log(error)
        })
    },
    togglerDrawer() {
      this.$emit('toggle')
    },
  },
  mounted() {
    this.fetchData()
  }
}
</script>

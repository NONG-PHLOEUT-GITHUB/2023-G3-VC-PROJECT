<template>
  <v-app-bar>
    <v-app-bar-nav-icon @click="togglerDrawer">
      <v-icon>mdi-menu</v-icon>
    </v-app-bar-nav-icon>
    <strong>School Management</strong>
    <v-spacer />
    <div>
      <v-list-item class="px-2">
        <v-menu rounded>
          <template v-slot:activator="{ props }">
            <strong class="me-6">{{ first_name }} {{ last_name }}</strong>
            <v-btn icon v-bind="props" class="me-5">
              <v-avatar color="brown" size="large" class="avatar">
                <v-img :src="profile_image" alt="Avatar" cover> </v-img>
              </v-avatar>
            </v-btn>
          </template>

          <v-list>
            <v-list-item>
              <v-avatar  size="large" class="avatar">
                <v-img :src="profile_image" alt="Avatar" cover > </v-img>
              </v-avatar>
              <span class="font-weight-black ms-2">
                {{ first_name }}
                {{ last_name }}
              </span>
              <br />
              <span class="email">{{ email }}</span>
            </v-list-item>

            <v-col cols="auto">
              <v-btn size="small" block variant="outlined" c olor="primary" to="/user-profile">
                user profile
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
import http from '@/api/api'
import ChangePasswordDialog from '@/views/auth/ChangePassword.vue'
import Sidebar from './Sidebar.vue'

export default {
  props: ['menubar'],
  name: 'LayoutDashboard',
  emits: ['toggle'],

  components: {
    ChangePasswordDialog,
    Sidebar
  },
  data: () => ({
    users: [],
    dialogVisible: false,
    first_name: '',
    last_name: '',
    profile_image: '',
    email: '',
    menus: [
      {
        title: 'Change password',
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

  methods: {
    async fetchData() {
      http.get('user').then(response => {
        this.users = response.data.data
        this.first_name = response.data.data.first_name
        this.last_name = response.data.data.last_name
        this.profile_image = response.data.data.profile
        this.email = response.data.data.email
      })
    },

    logoutUser() {
      http
        .post('/v1/auth/logout')
        .then(result => {
          if (result) {
            localStorage.removeItem('access_token')
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
  },
  mounted() {
    this.fetchData()
  }
}
</script>
<style scoped>
.avatar{
  border:solid rgb(105, 208, 208);
}
.font-weight-black{
  text-transform: uppercase;
}
</style>
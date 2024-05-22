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
            <strong class="me-6">{{ authUser.first_name }} {{ authUser.last_name }}</strong>
            <v-btn icon="" v-bind="props" class="me-5">
              <v-avatar color="brown" size="large" class="avatar">
                <v-img :src="authUser.profile" alt="Avatar" cover> </v-img>
              </v-avatar>
            </v-btn>
          </template>
          <v-list >
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
                <v-list-item-title
                  class="ms-3"
                  v-text="item.title"
                  :to="item.path"
                ></v-list-item-title>
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
import ChangePasswordDialog from '@/views/auth/ChangePassword.vue'
import Sidebar from './Sidebar.vue'
import { mapActions, mapState } from 'pinia'
import { useAuthStore } from '@/stores/auth'
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
        return fullName.substring(0, 15) + '...';
      } else {
        return fullName;
      }
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

<template>
  <v-navigation-drawer elevation="4" v-model="drawer" :width="280">
    <template v-slot:prepend>
      <v-list>
        <v-list-item>
          <v-img class="image" rounded src="/SMSLogo.ico" rounded-sm></v-img>
        </v-list-item>
      </v-list>
    </template>

    <v-list v-for="(link, i) in menu" :key="link.title" dense class="pa-0">
      <v-list-item
        v-if="!link.subLinks"
        :key="i"
        :to="link.path"
        class="v-list-item"
        exact
        color="primary"
      >
        <template v-slot:prepend>
          <v-icon olor="primary" :icon="link.icon"></v-icon>
        </template>
        <v-list-item-title class="primary--text">
          {{ link.title }}
        </v-list-item-title>
      </v-list-item>

      <v-list-group v-else :key="link.title" no-action>
        <template v-slot:activator="{ props }">
          <v-list-item v-bind="props">
            <template v-slot:prepend>
              <v-icon olor="primary" :icon="link.icon"></v-icon>
            </template>
            <v-list-item-title class="primary--text">
              {{ link.title }}
            </v-list-item-title>
          </v-list-item>
        </template>

        <v-list-item
          v-for="sublink in link.subLinks"
          :to="sublink.path"
          :key="sublink.title"
          exact
          color="primary"
        >
          <template v-slot:prepend>
            <v-icon olor="primary" :icon="sublink.icon"></v-icon>
          </template>
          <v-list-item-title class="primary--text">
            {{ sublink.title }}
          </v-list-item-title>
        </v-list-item>
      </v-list-group>
    </v-list>
    <template v-slot:append>
      <div class="pa-2 text-center">
        <v-btn
          block
          class="text-none bg-primary"
          variant="tonal"
          prepend-icon="mdi-application-outline"
        >
          Version 0.2.9
        </v-btn>
      </div>
    </template>
  </v-navigation-drawer>
</template>

<script>
  export default {
    data: () => ({
      links: [
        {
          title: 'Home',
          href: '/',
          icon: 'mdi-home-outline'
        },
        {
          icon: 'mdi-file-chart',
          title: 'Reports',
          subLinks: [
            {
              title: 'Sales',
              href: '/sales'
            },
            {
              title: 'Orders',
              href: '/orders'
            },
            {
              title: 'Inventory',
              href: '/inventory'
            }
          ]
        },
        {
          title: 'Statistics',
          href: '/statistics',
          icon: 'mdi-chart-bar'
        }
      ]
    }),
    computed: {
      userRole() {
        return parseInt(localStorage.getItem('user_role')) // set string to integer
      },
      adminMenu() {
        return [
          {
            path: '/admin-dashboard',
            title: this.$t('menu.admin.dashboard'),
            icon: 'mdi-home'
          },
          {
            icon: 'mdi-account-group-outline',
            title: this.$t('menu.admin.userMg'),
            subLinks: [
              {
                path: '/guardian-list',
                title: this.$t('menu.admin.parents'),
                icon: 'mdi-human-male-female-child'
              },
              {
                path: '/teacher-list',
                title: this.$t('menu.admin.teacher'),
                icon: 'mdi-human-male-board-poll'
              },
              {
                path: '/student-list',
                title: this.$t('menu.admin.student'),
                icon: 'mdi-account-school-outline'
              }
            ]
          },
          {
            path: '/class-list',
            title: this.$t('menu.admin.classroom'),
            icon: 'mdi-google-classroom'
          },
          {
            path: '/subject-list',
            title: 'Subject Management',
            icon: 'mdi-clipboard-text'
          },
          {
            path: '/subject-list',
            title: 'Certificate',
            icon: 'mdi-file-certificate-outline'
          },
          {
            path: '/subject-list',
            title: 'Examination',
            icon: 'mdi-file-certificate-outline'
          }
        ]
      },
      teacherMenu() {
        return [
          {
            path: '/teacher-dashboard',
            title: this.$t('menu.admin.dashboard'),
            icon: 'mdi-home'
          },
          {
            path: '/student-exam',
            title: this.$t('menu.teacher.exam'),
            icon: 'mdi-chart-line-variant'
          },
          {
            path: '/teacher-classroom',
            title: this.$t('menu.teacher.classTeaching'),
            icon: 'mdi-domain'
          }
        ]
      },
      studentMenu() {
        return [
          {
            path: '/student-home',
            title: this.$t('menu.admin.dashboard'),
            icon: 'mdi-home'
          },
          {
            path: '/student-attendance',
            title: this.$t('menu.student.attendance'),
            icon: 'mdi-progress-check'
          },
          {
            path: '/student-score/view',
            title: this.$t('menu.student.exam'),
            icon: 'mdi-chart-bar'
          },
          {
            path: '/student-comments',
            title: this.$t('menu.student.comment'),
            icon: ' mdi-comment'
          }
        ]
      },
      menu() {
        switch (this.userRole) {
          case 1:
            return this.adminMenu
          case 2:
            return this.teacherMenu
          case 3:
            return this.studentMenu
          default:
            return []
        }
      }
    },
    methods: {
      drawer() {
        return this.value
      }
    }
  }
</script>
<style>
  .v-list-group__items {
    margin-left: -35px;
  }
  .v-navigation-drawer {
    height: 100%;
    overflow-y: auto;
    overflow-x: hidden;
  }
</style>

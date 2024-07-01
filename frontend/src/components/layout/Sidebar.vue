<template>
  <v-navigation-drawer elevation="4" v-model="drawer" :width="300">
    <!-- expand-on-hover
  rail -->
    <template v-slot:prepend>
      <v-list>
        <v-list-item>
          <v-img class="image" rounded src="/SMSLogo.ico" rounded-sm></v-img>
        </v-list-item>
      </v-list>
    </template>

    <v-list v-for="(link, i) in links" :key="link.title">
        <v-list-item
          v-if="!link.subLinks"
          :key="i"
          :to="link.href"
          class="v-list-item"
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
            <v-list-item v-bind="props" >
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
            :to="sublink.href"
            :key="sublink.title"
          >
            <v-list-item-title class="primary--text">
              {{ sublink.title }}
            </v-list-item-title>
          </v-list-item>
        </v-list-group>
    </v-list>
  
    <v-list dense>
      <v-list-item
        v-for="(item, index) in menu"
        :key="index"
        link
        :to="item.path"
        exact
        color="primary"
      >
        <template v-slot:prepend>
          <v-icon :icon="item.icon"></v-icon>
        </template>
        <v-list-item-title>{{ item.title }}</v-list-item-title>
      </v-list-item>
    </v-list>
    <template v-slot:append>
      <div class="pa-2 text-center">
        <!-- <v-chip block>Version 0.2</v-chip> -->
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
      ],
      items: [
        {
          action: 'mdi-ticket',
          title: 'Attractions',
          items: [
            { title: 'List Item 1' },
            { title: 'List Item 2' },
            { title: 'List Item 3' }
          ]
        },
        {
          title: 'Dining',
          action: 'mdi-silverware-fork-knife',
          items: [
            { title: 'Breakfast & brunch' },
            { title: 'New American' },
            { title: 'Sushi' }
          ]
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
            icon: 'mdi-android-studio'
          },
          {
            path: '/class-list',
            title: this.$t('menu.admin.classroom'),
            icon: 'mdi-clipboard-text'
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

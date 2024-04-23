<template>
  <v-navigation-drawer elevation="4" v-model="drawer">
    <v-list>
      <v-list-item>
        <div class="image">
          <v-img
            class="image"
            src="https://www.ayushmatrimony.com/Services/assets/images/SMSLogo.png"
            rounded
            rounded-sm
          >
          </v-img>
        </div>
      </v-list-item>
    </v-list>
    <v-list dense>
      <v-list-item v-for="(item, index) in menu" :key="index" link :to="item.path" exact>
        <template v-slot:prepend>
          <v-icon :icon="item.icon"></v-icon>
        </template>
        <v-list-item-title>{{ item.title }}</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
// import { mapState } from 'pinia'
// import { useAuthStore } from '@/stores/auth'

export default {
  data: () => ({
    teacherMenu: [
      {
        path: '/teacher-dashboard',
        title: 'Dashboard',
        icon: 'mdi-home'
      },
      {
        path: '/check-attendance/student',
        title: 'Attendance',
        icon: 'mdi-calendar-check'
      },
      {
        path: '/student-score',
        title: 'Score Management',
        icon: 'mdi-chart-line-variant'
      },
      {
        path: '/teacher-classroom',
        title: 'Classroom',
        icon: 'mdi-domain'
      }
    ],
    studentMenu: [
      {
        path: '/student-home',
        title: 'Dashboard',
        icon: 'mdi-home'
      },
      {
        path: '/student-attendance',
        title: 'Attendance',
        icon: 'mdi-progress-check'
      },
      {
        path: '/student-scores',
        title: 'Score',
        icon: 'mdi-chart-bar'
      },
      {
        path: '/student-comments',
        title: 'Comment',
        icon: ' mdi-comment'
      }
    ],
    adminMenu: [
      {
        path: '/admin-dashboard',
        title: 'Dashboard',
        icon: 'mdi-home'
      },
      {
        path: '/student-attendance',
        title: 'Attendance',
        icon: 'mdi-progress-check'
      },
      {
        path: '/teacher-list',
        title: 'Teacher management',
        icon: 'mdi-human-male-board-poll'
      },
      {
        path: '/guardian-list',
        title: 'Guardian management',
        icon: 'mdi-human-male-female-child'
      },
      {
        path: '/student-list',
        title: 'Student management',
        icon: 'mdi-android-studio'
      },
      {
        path: '/class-list',
        title: 'Class management',
        icon: 'mdi-clipboard-text'
      }
    ],
    userProfile: [
      {
        path: '/user-profile',
        icon: 'mdi-clipboard-text'
      }
    ]
  }),
  computed: {
    menu() {
      switch (1) {
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
  // watch:{
  //   getRole(){
  //     this.getRole = parseInt(localStorage.getItem('user_role'));
  //   }
  // }
}
</script>

<template>
  <v-list dense>
    <v-list-item v-for="(item, index) in menubar" :key="index" link :to="item.path" exact>
      <template v-slot:prepend>
          <v-icon :icon="item.icon"></v-icon>
        </template>
      <v-list-item-title>{{ item.title }}</v-list-item-title>
    </v-list-item>
  </v-list>
</template>

<script>
export default {
  data: () => ({
    menubar: [
      {
        path: '/admin-dashboard',
        title: 'Dashboard',
        icon: 'mdi-home'
      },
      {
        path: '/teacher-list',
        title: 'Teacher list',
        icon: 'mdi-format-list-bulleted'
      },
      {
        path: '/guardian-list',
        title: 'Guardian list',
        icon: 'mdi-format-list-bulleted'
      },
      {
        path: '/student-list',
        title: 'Student list',
        icon: 'mdi-format-list-bulleted'
      },
      {
        path: '/class-list',
        title: 'Class Management',
        icon: 'mdi-clipboard-text'
      }
    ],
    userProfile: [
      {
        path: '/user-profile',
        title: 'Class Management',
        icon: 'mdi-clipboard-text'
      }
    ]
  })
}
</script>

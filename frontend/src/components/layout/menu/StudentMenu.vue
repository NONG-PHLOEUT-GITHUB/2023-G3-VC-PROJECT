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
        path: "/student-home",
        title: "Dashboard",
        icon: "mdi-home",
      },
      {
        path: "/student-attendance",
        title: "Attendance",
        icon: "mdi-progress-check",
      },
      {
        path: "/student-scores",
        title: "Score",
        icon: "mdi-chart-bar",
      },
      {
        path: "/student-comments",
        title: "Comment",
        icon: " mdi-comment",
      },
    ],
  }),
};
</script>

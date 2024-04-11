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
        path: "/teacher-dashboard",
        title: "Dashboard",
        icon: "mdi-home",
      },
      {
        path: "/check-attendance",
        title: "Attendance",
        icon: "mdi-calendar-check",
      },
      {
        path: "/student-score",
        title: "Score Management",
        icon: "mdi-chart-line-variant",
      },
      {
        path: "/teacher-classroom",
        title: "Classroom",
        icon: "mdi-domain",
      },
    ],
  }),
};
</script>

<template>
  <main-dashboard :menubar="menubar"></main-dashboard>
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
        icon: "mdi-school",
      },
      {
        path: "/student-score",
        title: "score",
        icon: "mdi-home",
      },
      {
        path: "/teacher-classroom",
        title: "classroom",
        icon: "mdi-home",
      },
    ],
  }),
};
</script>

<template>
    <main-dashboard :menubar="menubar"></main-dashboard>
</template>

<script>


export default {
  data: () => ({
    menubar: [
      {
        path: '/student-list',
        title: "Dashboard",
        icon: 'mdi-home'
      },
      {
        path: '/class-list',
        title: "Dashboard",
        icon: 'mdi-home'
      },
      {
        path: '/student-attendance',
        title: "My Attendance",
        icon: 'mdi-school'
      },
      {
        path: '/student-score',
        title: " My score",
        icon: 'mdi-home'
      },
    ],
  })
}
</script>
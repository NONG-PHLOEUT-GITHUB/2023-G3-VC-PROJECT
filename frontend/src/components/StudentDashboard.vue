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
      path: '/student-attendance',
      title: "Attendance",
      icon: 'mdi-progress-check'
    },
    {
      path: '/student-acadamice',
      title: "Score",
      icon: 'mdi-chart-bar'
    },
  ],
})
}
</script>
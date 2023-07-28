<template>
  <main-dashboard :menubar="menubar"></main-dashboard>
</template>

<script>


export default {
data: () => ({
  menubar: [
    {
      path: '/student-dashboard',
      title: "Dashboard",
      icon: 'mdi-home'
    },
    {
      path: '/student-attendance',
      title: "Attendance",
      icon: 'mdi-progress-check'
    },
    {
      path: '/student-scores',
      title: "Score",
      icon: 'mdi-chart-bar'
    },
  ],
})
}
</script>
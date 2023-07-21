<template>
  <main-dashboard :menubar="menubar"></main-dashboard>
</template>

<script>


export default {
data: () => ({
  menubar: [
    {
      path: '/studnet-home',
      title: "Dashboard",
      icon: 'mdi-home'
    },
    {
      path: '/studnet-attendance',
      title: "Attendance",
      icon: 'mdi-progress-check'
    },
    {
      path: '/studnet-scores',
      title: "Score",
      icon: 'mdi-chart-bar'
    },
  ],
})
}
</script>
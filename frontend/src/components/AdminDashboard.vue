<template>
    <main-dashboard :menubar="menubar"></main-dashboard>
</template>

<script>


export default {
  data: () => ({
    menubar: [
      {
        path: '/home',
        title: "Dashboard",
        icon: 'mdi-home'
      },
      {
        path: '/add-teacher',
        title: "Add teacher",
        icon: 'mdi-home'
      },
      {
        path: '/student_list',
        title: "Student list",
        icon: 'mdi-home'
      },
      {
        path: '/student-list',
        title: "Add student",
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
      {
        path: '/class_list',
        title: "Class",
        icon: 'mdi-chart-bar'
      },
    ],
  })
}
</script>
<template>
  <!-- <AdminMenu></AdminMenu> -->
  <!-- <StudentMenu/> -->
  <TeacherMenu/>
</template>

<script>
// import AdminMenu from './menu/AdminMenu.vue'
// import StudentMenu from './menu/StudentMenu.vue'
import TeacherMenu from './menu/TeacherMenu.vue'
// import AdminMenu from './menu/AdminMenu.vue'
export default {
  components: {
    // AdminMenu,
    // StudentMenu,
    TeacherMenu
  },
  data() {
    return {
      role: null
    }
  },
  methods: {
    getRole() {
      let cookies = Cookies.get('user_role')
      this.role = cookies
    }
  }
}
</script>

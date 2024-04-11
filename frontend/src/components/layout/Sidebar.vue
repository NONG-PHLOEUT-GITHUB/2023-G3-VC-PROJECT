<template></template>

<script>
// import AdminMenu from 'menu/'
export default {
  data() {
    return {
        role:null
    },
  },
  methods: {
    getRole() {
      let cookies = Cookies.get('user_role')
      this.role = cookies
    }
  }
}
</script>

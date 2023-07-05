<template>
<login-view></login-view>
<save-list-student></save-list-student>
  
</template>

<script>
import LoginView from './views/Login/LoginView.vue'
import SaveListStudent from './views/Student/SaveListStudent.vue'

export default {
  data(){
    return{
      students:[]
    }
  },
  components:{
    LoginView,
    SaveListStudent
  }

}
</script>

<style>

</style>
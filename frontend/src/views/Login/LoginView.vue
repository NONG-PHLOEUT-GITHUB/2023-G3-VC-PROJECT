<template>
  <div class="login">
    <div  class="  mt-3 d-flex container w-50 shadow-lg p-5 mb-5 bg-body-tertiary rounded">
      <div class="img w-100">
            <div class="color">
                   <img class="img" src="../../assets/schoolicon.png">
                   <h5 class="h5">PRINAVISCHOOL</h5>
            </div>
         
            <img src="../../assets/study.png" alt="">
      </div>
    
      <form class="w-100 m-auto">
        <h2>Login</h2>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          <input type="text" v-model="email" class="form-control">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>

          <input type="password" v-model="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-5 form-check">
          <input type="checkbox"  class="exampleCheck1 form-check-input" id="exampleCheck1">
          <label class="check form-check-label label" for="exampleCheck1">Remember me</label>
          <a href="#!">Forgot password?</a>
        </div>
        
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  
    data(){
        return {
            name:'',
            email:'',
            password:''
        }
    },
    methods:{
        
    }
}
</script>

<style>
img {
        width: 90%;
  
    }
.login{
    margin: auto;
    margin-top: 9%;

}

h2{
    justify-content: center;
    margin: auto;
    text-align: center;
}
a{
    margin-left: 80px;
}
button{
    width: 100%;
    
}
.image{
    width: 10%;
    margin-bottom:10% ;
   
}
.color{
    display: flex;
    width: 40%;
}
.h5{
    margin-top: 30%;
    color: rgb(33, 162, 205);
}

</style>
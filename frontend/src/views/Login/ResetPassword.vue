<template>
  <div class="container d-flex flex-column">
      <div class=" row align-items-center 
          min-vh-100">
        <div class=" div col-12 col-md-8 col-lg-4 ">
            <img src="../../assets/resetpassword.jpg">
          <div >
            <div class="main  shadow-lg">
            <div class="card-body">
              <div class="mb-4">
                <h3>Reset Password</h3>
              </div>
              <form>
                <div class="mb-3">
                  <label for="email" class="form-label">Password</label>
                  <input type="password" id="email" class="form-control" name="email" placeholder="Enter Your password"
                    required="">
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">New Password</label>
                  <input type="password" id="email" class="form-control" name="email" placeholder="Enter Your New password"
                    required="">
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Comfrim Password</label>
                  <input type="password" id="email" class="form-control" name="email" placeholder="Comfrim Password"
                    required="">
                </div>
                <div class="mb-3 d-grid">
                  <button type="submit" class="btn btn-primary">
                    Reset Password
                  </button>
                </div>
              </form>
            </div>
          </div>
          </div>
        </div>
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
        width: 120%;
  
    }
.login{
    margin: auto;
    margin-top: 9%;

}
.main{
    background: white;
    width: 350%;
    border: solid 1px rgb(241, 235, 225);
  
}
h3{
    text-align: center;

}
button{
    width: 100%;
}
.div{
    display: flex;
    margin-left: 90px;
}

</style>
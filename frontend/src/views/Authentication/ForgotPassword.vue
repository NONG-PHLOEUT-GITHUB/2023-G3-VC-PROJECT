<template>
  <div class="container d-flex flex-column">
    <div class="row align-items-center min-vh-100">
      <div class="div col-12 col-md-8 col-lg-4">
        <img src="../../assets/resetpassword.jpg" />
        <div>
          <form class="rounded bg-white shadow p-7 main shadow-lg">
            <h3 class="text-dark fw-bolder fs-4 mb-2">Forget Password ?</h3>

            <div class="fw-normal text-muted mb-4">
              Enter your email to reset your password.
            </div>

            <div class="form-floating mb-3">
              <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" />
              <label for="floatingInput">Email address</label>
            </div>

            <button type="submit" class="btn btn-primary submit_btn my-4">
              Submit
            </button>
            <button type="submit" class="btn btn-secondary submit_btn my-4 ms-3">
              Cancel
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {}

</script>

<style scoped>
img {
  width: 120%;
}

.main {
  background: white;
  width: 350%;
  padding: 30px;
  border: solid 1px rgb(241, 235, 225);
}

h3 {
  text-align: center;
}

button {
  width: 30%;
}

.div {
  display: flex;
  margin-left: 90px;
}
</style>
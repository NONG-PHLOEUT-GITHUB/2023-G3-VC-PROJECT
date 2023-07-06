<template>
  <div class="container d-flex flex-column">
    <div class="row align-items-center min-vh-100">
      <div class="div col-12 col-md-8 col-lg-4">
        <img src="../../assets/resetpassword.jpg" />
        <div>
          <form class="rounded bg-white shadow p-7 main shadow-lg">
            <h3 class="text-dark fw-bolder fs-4 mb-2">Setup New Password</h3>

            <div class="fw-normal text-muted mb-2">
              Please create new password!!
            </div>

            <div class="form-floating mb-3">
              <input
                type="password"
                class="form-control"
                id="floatingPassword"
                placeholder="Password"
              />
              <label for="floatingPassword">Password</label>
            </div>
            <div class="form-floating mb-3">
              <input
                type="password"
                class="form-control"
                id="floatingPassword"
                placeholder="Password"
              />
              <label for="floatingPassword">Confirm Password</label>
            </div>
            <div class="form-check d-flex align-items-center">
              <input
                class="form-check-input"
                type="checkbox"
                id="gridCheck"
                checked
              />
              <label class="form-check-label ms-2" for="gridCheck">
                I Agree <a href="#">Terms and conditions</a>.
              </label>
            </div>
            <button type="submit" class="btn btn-primary submit_btn w-70 my-4">
              submit
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
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
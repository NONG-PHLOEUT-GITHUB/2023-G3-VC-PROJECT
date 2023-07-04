<template>
    <form class="row g-2 needs-validation container" novalidate>
    <div class="title">
        <h3>CREATE USER</h3>
    </div>
    <div class="col-md-6">
        <label for="validationCustom01" class="form-label ">First name</label>
        <input type="text" class="form-control" id="validationCustom01" value=""  required>
        <div class="valid-feedback">
        Looks good!
        </div>
    </div>
    <div class="col-md-6">
        <label for="validationCustom02" class="form-label">Last name</label>
        <input type="text" class="form-control" id="validationCustom02" value="" required>
        <div class="valid-feedback">
        Looks good!
        </div>
    </div>
    <div class="col-md-6">
        <label for="validationCustom02" class="form-label">Email</label>
        <input type="text" class="form-control" id="validationCustom02" value="" required>
        <div class="valid-feedback">
        Looks good!
        </div>
    </div>
    <div class="col-md-6">
        <label for="validationCustom02" class="form-label">Password</label>
        <input type="text" class="form-control" id="validationCustom02" value="" required>
        <div class="valid-feedback">
        Looks good!
        </div>
    </div>
    <div class="col-md-6">
        <label for="validationCustom02" class="form-label">Phone Number</label>
        <input type="tel" class="form-control" id="phoneNumber" placeholder="">
        <div class="valid-feedback">
        Looks good!
        </div>
    </div>
    <div class="col-md-6">
        <label for="validationCustom02" class="form-label">Address</label>
        <input type="tel" class="form-control" id="addreess" placeholder="   ">
        <div class="valid-feedback">
        Looks good!
        </div>
    </div>
    <div class="col-md-6">
        <label for="validationCustom02" class="form-label">Date of Birth</label>
        <input type="date" class="form-control" id="dateOfBirth" placeholder="">
        <div class="valid-feedback">
        Looks good!
        </div>
    </div>
    <div class="col-md-6">
        <label for="validationCustom02" class="form-label">Age</label>
        <input type="number" class="form-control" id="dateOfBirth" placeholder=""> 
        <div class="valid-feedback">
        Looks good!
        </div>
    </div>
    
    <div class="col-md-4">
        <label for="validationCustom02" class="form-label">Profile</label>
        <input type="file" class="form-control-file" id="fileInput" placeholder="Choose File">
        <div class="valid-feedback">
        Looks good!
        </div>
    </div>
    <div class="col-md-4">
        <label for="validationCustom02" class="form-label">Gender</label>
        <div class="gender">
            <input type="radio" name="gender" id="male" value="male" class="form-check-input">
            <label class="form-check-label" for="male">Male</label> 
            <input type="radio" name="gender" id="female" value="female" class="form-check-input ml-5">
            <label class="form-check-label" for="female">Female</label>
        </div>
    </div>
    <div class="col-md-4">
        <label for="validationCustom02" class="form-label">Role</label>
        <select class="form-select" required aria-label="select example">
        <option  selected>Choose role</option>
        <option value="director">Director</option>
        <option value="teacher">Teacher</option>
        <option value="student">Student</option>
        </select>
        <div class="invalid-feedback">Example invalid select feedback</div>
  </div>
 
    <div class="col-12">
        <div class="form-check">
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
        </div>
    </div>
    <div class="col-8 mx-auto">
        <button class="btn btn-primary mx-auto fw-bold" type="submit">ADD USER</button>
    </div>
    </form>
  </template>
<script >
// // Example starter JavaScript for disabling form submissions if there are invalid fields
// (function () {
//     'use strict'

//     // Fetch all the forms we want to apply custom Bootstrap validation styles to
//     var forms = document.querySelectorAll('.needs-validation')

//     // Loop over them and prevent submission
//     Array.prototype.slice.call(forms)
//         .forEach(function (form) {
//             form.addEventListener('submit', function (event) {
//                 if (!form.checkValidity()) {
//                     event.preventDefault()
//                     event.stopPropagation()
//                 }

//                 form.classList.add('was-validated')
//             }, false)
//         })
// })()
</script>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

    .container{
        font-family: 'Roboto', sans-serif;
        margin: auto;
        margin-top: 30px;
        padding: 20px;
        width: 50%;
        border-radius: 10px;
        box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
    }
   h3{
    color: rgb(21, 26, 27);
    font-weight: bold;
    text-align: center;
   }
   button{
    width: 100%;
   }
</style>
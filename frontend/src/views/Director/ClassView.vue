<template>
  <div class="card shadow border-0 mb-7">
      <div class="card-header">
          <h3 class="mb-0 text-primary">CLASSES LIST</h3>
      </div>
      <div class="card-header">
          <div class="form-group d-flex justify-content-between mb-3" style="width: 100%;">
              <form class="form-inline my-2 my-lg-0 d-flex" style="width: 60%;">
                  <input class="form-control mr-sm-2" type="search" placeholder="Search class" aria-label="Search" style="width: 78%;">
                  <button class="btn btn-outline-warning my-2 my-sm-0 " type="button"><i class="bi bi-search"></i> Search</button>
              </form>
              <router-link :to="{ path: '/createUser' }" class="text-white" style="width: 20%;"><button type="button" class="btn btn-primary align-self-end" style="width: 100%;"><i class="bi bi-building"></i> Add new class</button></router-link>
          </div>
      </div>
      <div class="card-header">
          <h5 class="mb-0 p-0 text-primary">GRADE 10</h5>
      </div>
      <div class="table-responsive">
          <table class="table table-hover table-nowrap">
              <thead class="thead-light">
                  <tr>
                      <th scope="col">Class</th>
                      <th scope="col">Total students</th>
                      <th scope="col">Teacher</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="student of studentsList" :key="student" class="border-2-dark">
                      <td>
                          <img alt="..."
                              src="https://images.unsplash.com/photo-1502823403499-6ccfcf4fb453?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80"
                              class="avatar avatar-sm rounded-circle me-2">
                          <a class="text-heading font-semibold" href="#">
                              {{student.name}}
                          </a>
                      </td>
                      <td>
                          {{student.teacher}}
                      </td>
                      <td>
                          {{student.students}}
                      </td>
                      <td class="text-end d-flex justify-content-end">
                          <button type="button" class="btn btn-sm btn-neutral text-dark text-primary-hover">
                              View Score List
                          </button>
                          <button type="button" class="btn btn-sm btn-neutral text-dark text-primary-hover ml-2">
                              View Attendance List
                          </button>
                      </td>
                  </tr>
              </tbody>
          </table>
      </div>
  </div>
</template>
<script>
export default {
  data() {
      return {
          studentsList: [
              {name: "Class 10A", students: 53, teacher: "Sreypok Doem"},
              {name: "Class 10B", students: 53, teacher: "Sreypok Doem"},
              {name: "Class 10C", students: 53, teacher: "Sreypok Doem"},
              {name: "Class 10D", students: 53, teacher: "Sreypok Doem"},
              {name: "Class 10E", students: 53, teacher: "Sreypok Doem"},
              {name: "Class 10C", students: 53, teacher: "Sreypok Doem"},
              {name: "Class 10D", students: 53, teacher: "Sreypok Doem"},
              {name: "Class 10E", students: 53, teacher: "Sreypok Doem"},
              {name: "Class 10C", students: 53, teacher: "Sreypok Doem"},
              {name: "Class 10D", students: 53, teacher: "Sreypok Doem"},
              {name: "Class 10E", students: 53, teacher: "Sreypok Doem"},
          ]
      }
  }
}
</script>
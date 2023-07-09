<template>
    <main class="py-6 bg-surface-secondary rounded-3 mb-4">
    <div class="container-fluid">
      <div class="row g-6 mb-6 ">
        <div class="col-xl-4 col-sm-6 col-12 ">
          <div class="card shadow border-0 bg-gray-200">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <span class="h3 font-semibold d-block mb-2">Grade 10</span>
                  <span class="h3 font-bold mb-0">15 Class</span>
                </div>
                <div class="col-auto">
                  <div
                    class="icon icon-shape bg-tertiary text-white text-lg rounded-circle"
                  >
                  <i class="bi bi-building"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 col-12">
          <div class="card shadow border-0 bg-gray-200">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <span class="h3 font-semibold d-block mb-2"
                    >Grade 11</span
                  >
                  <span class="h3 font-bold mb-0">15 Class</span>
                </div>
                <div class="col-auto">
                  <div
                    class="icon icon-shape bg-primary text-white text-lg rounded-circle"
                  >
                  <i class="bi bi-building"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 col-12">
          <div class="card shadow border-0 bg-gray-200">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <span class="h3 font-semibold d-block mb-2"
                    >Grade 12</span
                  >
                  <span class="h3 font-bold mb-0">15 Class</span>
                </div>
                <div class="col-auto">
                  <div
                    class="icon icon-shape bg-info text-white text-lg rounded-circle"
                  >
                    <i class="bi bi-building"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>
</main>
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
          <h3 class="mb-0 p-0 text-primary">GRADE 10</h3>
      </div>
      <div class="table-responsive">
          <table class="table table-hover table-nowrap">
              <thead class="bg-primary">
                  <tr>
                      <th scope="col" class="fs-5  text-light">Class</th>
                      <th scope="col" class="fs-5 text-light">Total students</th>
                      <th scope="col" class="fs-5 text-light">Teacher</th>
                      <th scope="col" class="text-center fs-5 text-light">Action</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="student of studentsList" :key="student" class="border-2-dark">
                      <td>
                        <i class="bi bi-building"></i>
                            {{student.name}}
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
                          <button type="button" class="btn btn-sm btn-neutral text-dark text-primary-hover ml-2">
                              View Student List
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
<template>
    <div class="card shadow border-0 mb-7">
      <div class="card-header">
          <h3 class="mb-0 text-primary">ATTENDANCE LIST OF MAY</h3>
      </div>
      <div class="card-header">
          <div class="form-group d-flex justify-content-between mb-3" style="width: 100%;">
              <form class="form-inline my-2 my-lg-0 d-flex" style="width: 60%;">
                  <input class="form-control mr-sm-2" type="search" placeholder="Search student" aria-label="Search" style="width: 78%;" v-model="search">
                  <button class="btn btn-outline-warning my-2 my-sm-0 " type="button"><i class="bi bi-search"></i> Search</button>
              </form>
          </div>
      </div>
      <div class="card-header">
          <h3 class="mb-0 p-0 text-primary">CLASS 12A</h3>
      </div>
      <div class="table-responsive">
          <table class="table table-hover table-nowrap">
              <thead class="bg-primary">
                  <tr>
                      <th scope="col" class="fs-6 text-light">Student name</th>
                      <th scope="col" class="fs-6 text-light">Gender</th>
                      <th scope="col" class="fs-6 text-light">Total absence</th>
                      <th scope="col" class="fs-6 text-light">Action</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="student of studentsList" :key="student" class="border-2-dark">
                      <td>
                        <img alt=""
                                src="https://play-lh.googleusercontent.com/pjPN53lzZhnsxtS7IaxxT8WndB6Imi8JjD1P7xLSJnnbCKyDPHRyvvy30KsGH-0mmQ"
                                class="avatar avatar-sm rounded-circle me-2">
                            <a class="text-heading font-semibold" href="#">
                                {{student.name}} 
                            </a>
                      </td>
                      <td>
                          {{student.gender}}
                      </td>
                      <td>
                          {{student.total_absence}}
                      </td>
                      <td class="text-end d-flex justify-content-start">
                            <router-link :to="{ path: '/home' }">
                              <button type="button" class="btn btn-sm btn-neutral text-dark text-primary-hover bg-gray-300">
                                <i  class="bi bi-calendar2-week-fill text-warning" ></i> View Details
                              </button>
                            </router-link>
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
            {name: "Rien Leam", total_absence: 53, gender: "Male"},
            {name: "Rien Leam", total_absence: 53, gender: "Male"},
            {name: "Rien Leam", total_absence: 53, gender: "Male"},
            {name: "Rien Leam", total_absence: 53, gender: "Male"},
            {name: "Rien Leam", total_absence: 53, gender: "Male"},
            {name: "Rien Leam", total_absence: 50, gender: "Male"},
            {name: "Rien Leam", total_absence: 50, gender: "Male"},
            {name: "Rien Leam", total_absence: 50, gender: "Male"},
            {name: "Rien Leam", total_absence: 50, gender: "Male"},
            {name: "Rien Leam", total_absence: 50, gender: "Male"},
            {name: "Rien Leam", total_absence: 47, gender: "Male"},
            {name: "Rien Leam", total_absence: 47, gender: "Male"},
            {name: "Rien Leam", total_absence: 47, gender: "Male"},
            {name: "Rien Leam", total_absence: 47, gender: "Male"},
            {name: "Rien Leam", total_absence: 47, gender: "Male"}
        ]
      }
    },
}
</script>
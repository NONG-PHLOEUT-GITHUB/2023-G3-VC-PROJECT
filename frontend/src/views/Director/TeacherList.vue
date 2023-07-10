<template>
  <div class="card shadow border-0 mb-7">
    <div class="card-header">
      <h3 class="mb-0 text-primary">TEACHERS LIST</h3>
    </div>
    <div class="card-header">
      <div class="form-group d-flex justify-content-between mb-3" style="width: 100%;">
        <form class="form-inline my-2 my-lg-0 d-flex" style="width: 60%;">
          <input class="form-control mr-sm-2" type="search" placeholder="Search teacher" aria-label="Search" style="width: 78%;" v-model="searchQuery">
          <button class="btn btn-outline-warning my-2 my-sm-0 " type="button" ><i class="bi bi-search"></i> Search</button>
        </form>
        <router-link :to="{ path: '/createUser' }" class="text-white" style="width: 20%;">
          <button type="button" class="btn btn-primary align-self-end" style="width: 100%;">
            <i class="bi bi-person-plus-fill"></i> Add new teacher
          </button>
        </router-link>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-nowrap">
        <thead class="bg-primary">
          <tr>
            <th scope="col" class="fs-6 text-light">Name</th>
            <th scope="col" class="fs-6 text-light">Gender</th>
            <th scope="col" class="fs-6 text-light">age</th>
            <th scope="col" class="fs-6 text-light">class</th>
            <th scope="col" class="fs-6 text-light">Subject</th>
            <th scope="col" class="fs-6 text-light">phone number</th>
            <th scope="col" class="fs-6 text-light">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="teacher of filteredTeacherList" :key="teacher" class="border-2-dark">
            <td>
              <img alt="..." src="https://images.unsplash.com/photo-1502823403499-6ccfcf4fb453?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" class="avatar avatar-sm rounded-circle me-2">
              <a class="text-heading font-semibold" href="#">{{teacher.name}}</a>
            </td>
            <td>{{teacher.gender}}</td>
            <td>{{teacher.age}}</td>
            <td>{{teacher.class}}</td>
            <td>{{teacher.subject}}</td>
            <td>{{teacher.phone}}</td>
            <td class="text-end d-flex justify-content-end">
              <button type="button" class="btn btn-sm btn-neutral text-dark text-primary-hover bg-gray-300">
                <i class="bi bi-person-circle text-warning"></i> View Profile
              </button>
              <button type="button" class="btn btn-sm btn-neutral text-white text-dark-hover bg-warning ml-2">
                <i class="bi bi-pencil-square"></i> Edit
              </button>
              <button type="button" class="btn btn-sm btn-neutral text-white text-dark-hover bg-danger ml-2">
                <i class="bi bi-trash-fill"></i> Delete
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
      teacherList: [
        {name: "Rien Leam", gender: "Male", age: 34, class: "12A", subject: "Math", phone: "0977348624"},
        {name: "Sophia Williams", gender: "Female", age: 28, class: "12A", subject: "English", phone: "0977348624"},
        {name: "John Doe", gender: "Male", age: 32, class: "12A", subject: "Science", phone: "0977348624"},
        {name: "Jane Smith", gender: "Female", age: 27, class: "12A", subject: "History", phone: "0977348624"},
        {name: "David Lee", gender: "Male", age: 39, class: "12A",subject: "Physical Education", phone: "0977348624"},
        {name: "Maria Rodriguez", gender: "Female", age: 34, class: "12A", subject: "Spanish", phone: "0977348624"},
        {name: "Mohammed Ahmed", gender: "Male", age: 28, class: "12A", subject: "Arabic", phone: "0977348624"},
        {name: "Emily Chen", gender: "Female", age: 32, class: "12A", subject: "Chinese", phone: "0977348624"},
        {name: "Carlos Ramirez", gender: "Male", age: 27, class: "12A", subject: "French", phone: "0977348624"},
        {name: "Makoto Tanaka", gender: "Male", age: 39, class: "12A", subject: "Japanese", phone: "0977348624"},
      ],
      searchQuery: "",
    };
  },
  computed: {
    filteredTeacherList() {
        if (this.searchQuery === "") {
            return this.teacherList;
        } else {
            const filtered = this.teacherList.filter((teacher) =>
                teacher.name.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
            if (filtered.length === 0) {
            return [{ name: "Teacher not found", students: [], classes: [] }];
            } else {
            return filtered;
            }
        }
    },
  },
  
};
</script>

<style scoped>
/* td{
    font-size: 25px;
    color: red;
} */
</style>
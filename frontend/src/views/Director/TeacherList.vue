<template>
    <div class="card shadow border-0 mb-7">
        <div class="card-header">
            <h3 class="mb-0 text-primary">TEACHERS LIST</h3>
        </div>
        <div class="card-header">
            <div class="form-group d-flex justify-content-between mb-3" style="width: 100%;">
                <form class="form-inline my-2 my-lg-0 d-flex" style="width: 60%;">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search teacher" aria-label="Search" style="width: 78%;">
                    <button class="btn btn-outline-warning my-2 my-sm-0 " type="button"><i class="bi bi-search"></i> Search</button>
                </form>
                <router-link :to="{ path: '/createUser' }" class="text-white" style="width: 20%;"><button type="button" class="btn btn-primary align-self-end" style="width: 100%;"><i class="bi bi-person-plus-fill"></i> Add new teacher</button></router-link>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-nowrap">
                <thead class="thead-light">
                    <tr >
                        <th scope="col" class="fs-6">Name</th>
                        <th scope="col" class="fs-6">Gender</th>
                        <th scope="col" class="fs-6">age</th>
                        <th scope="col" class="fs-6">class</th>
                        <th scope="col" class="fs-6">Subject</th>
                        <th scope="col" class="fs-6">phone number</th>
                        <th scope="col " class="fs-6 text-center">Action</th>
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
                            {{student.gender}}
                        </td>
                        <td>
                            {{student.age}}
                        </td>
                        <td>
                            {{student.class}}
                        </td>
                        <td>
                            {{student.phone}}
                        </td>
                        <td>
                            {{student.phone}}
                        </td>
                        <td class="text-end d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-neutral text-dark text-primary-hover bg-gray-300">
                                <i class="bi bi-person-circle"></i> View Profile
                            
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
            studentsList: [
                {name: "Rien Leam", gender: "Male", age: 34, class: "12A", phone: "0977348624"},
                {name: "Rien Leam", gender: "Male", age: 28, class: "12A", phone: "0977348624"},
                {name: "Rien Leam", gender: "Male", age: 32, class: "12A", phone: "0977348624"},
                {name: "Rien Leam", gender: "Male", age: 27, class: "12A", phone: "0977348624"},
                {name: "Rien Leam", gender: "Male", age: 39, class: "12A", phone: "0977348624"},
                {name: "Rien Leam", gender: "Male", age: 34, class: "12A", phone: "0977348624"},
                {name: "Rien Leam", gender: "Male", age: 28, class: "12A", phone: "0977348624"},
                {name: "Rien Leam", gender: "Male", age: 32, class: "12A", phone: "0977348624"},
                {name: "Rien Leam", gender: "Male", age: 27, class: "12A", phone: "0977348624"},
                {name: "Rien Leam", gender: "Male", age: 39, class: "12A", phone: "0977348624"},
            ]
        }
    }
}
</script>
<style scoped>
/* td{
    font-size: 25px;
    color: red;
} */

</style>
<template>
    <div class="student-list">
        <h1 class="text-primary">All students</h1>
        <select class="form-select mb-3 mt-4" aria-label="Default select example" style="width: 30%;">
            <option selected disabled>Select grade</option>
            <option value="10">Grade 10</option>
            <option value="11">Grade 11</option>
            <option value="12">Grade 12</option>
        </select>
        <div class="form-group d-flex justify-content-between mb-3" style="width: 100%;">
            <form class="form-inline my-2 my-lg-0 d-flex" style="width: 60%;">
                <input class="form-control mr-sm-2" type="search" placeholder="Search student" aria-label="Search" style="width: 80%;">
                <button class="btn btn-outline-warning my-2 my-sm-0 " type="button">Search</button>
            </form>
            <button type="button" class="btn btn-primary align-self-end" style="width: 20%;">Add new student</button>
        </div>
        <h2 class="text-primary">Grade 10</h2>
        <div class="student-ten">
            <div class="row" v-for="(student, index) of studentsTen" :key="index" style="width: 100%;">
                <hr>
                <div class="name" style="width: 75%;">
                    <p>{{ index + 1 }}. <b> {{student.name}}</b></p>
                </div>
                <div class="group-btn d-flex align-items-center justify-content-between" style="width: 25%;">
                    <button type="button" class="btn btn-warning align-self-start p-0 text-white" style="width: 45%;">Edit</button>
                    <button type="button" class="btn btn-danger align-self-start p-0" style="width: 50%;">Delete</button>
                </div>
            </div>
        </div>
        <h2 class="text-primary">Grade 11</h2>
        <div class="student-ten">
            <div class="row" v-for="(student, index) of studentsTen" :key="index" style="width: 100%;">
                <hr>
                <div class="name" style="width: 75%;">
                    <p>{{ index + 1 }}. <b> {{student.name}}</b></p>
                </div>
                <div class="group-btn d-flex align-items-center justify-content-between" style="width: 25%;">
                    <button type="button" class="btn btn-warning align-self-start p-0 text-white" style="width: 45%;">Edit</button>
                    <button type="button" class="btn btn-danger align-self-start p-0" style="width: 50%;">Delete</button>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
export default {
    data() {
        return {
            studentsTen: [
                {name: "Rien Rien"},
                {name: "Nong Nong"},
                {name: "Linna Linna"},
                {name: "Navy Navy"},
                {name: "Zeiipok Zeiipok"},
            ]
        }
    }
}
</script>
<style>
.student-list {
    margin: 30px;
}
.student-ten {
    padding: 0 30px 0 30px;
    margin: 20px 0 20px 0;
    border-radius: 10px;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;  
}
.group-btn {
    display: flex;
    align-items: center;
}
.row:hover {
    background-color: rgb(199, 232, 240);
}
</style>
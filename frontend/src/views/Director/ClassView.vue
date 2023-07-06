
<template>
    <div class="class-container">
        <div class="classes">
            <div class="card">
                <img class="card-img-top" src="../../assets/grade10.png" alt="Card image cap" style="width: 100%" />
                <div class="card-body">
                    <h2 class="card-title p-0 m-0 text-primary">Grade 10</h2>
                    <span class="card-text">14 classes</span>
                </div>
            </div>
            <div class="card">
                <img class="card-img-top" src="../../assets/grade11.png" alt="Card image cap" style="width: 100%" />
                <div class="card-body">
                    <h2 class="card-title p-0 m-0 text-primary">Grade 11</h2>
                    <span class="card-text">12 classes</span>
                </div>
            </div>
            <div class="card">
                <img class="card-img-top" src="../../assets/grade12.png" alt="Card image cap" style="width: 100%" />
                <div class="card-body">
                    <h2 class="card-title p-0 m-0 text-primary">Grade 12</h2>
                    <span class="card-text">17 classes</span>
                </div>
            </div>
            <div class="card">
                <img class="card-img-top" src="../../assets/classes.png" alt="Card image cap" style="width: 100%" />
                <div class="card-body">
                    <h2 class="card-title p-0 m-0 text-primary">All Classes</h2>
                    <span class="card-text">43 classes</span>
                </div>
            </div>
        </div>
        <h1 class="text-primary">Grade 10</h1>
        <div class="grade-ten">
            <div class="row" v-for="(grade, index) of gradeTen" :key="index">
                <hr>
                <div class="col">
                    <p>{{ index + 1 }}. <b> {{ grade.name }}</b></p>
                </div>
                <div class="col d-flex justify-content-between">
                    <a href="#"><b>Score List</b></a>
                    <a href="#"><b>Attendance List</b></a>
                </div>
            </div>
        </div>
        <h1 class="text-primary">Grade 11</h1>
        <div class="grade-ten">
            <div class="row" v-for="(grade, index) of gradeEleven" :key="index">
                <hr>
                <div class="col">
                    <p>{{ index + 1 }}. <b> {{ grade.name }}</b></p>
                </div>
                <div class="col d-flex justify-content-between">
                    <a href="#"><b>Score List</b></a>
                    <a href="#"><b>Attendance List</b></a>
                </div>
            </div>
        </div>
        <h1 class="text-primary">Grade 12</h1>
        <div class="grade-ten">
            <div class="row" v-for="(grade, index) of gradeTwelve" :key="index">
                <hr>
                <div class="col">
                    <p>{{ index + 1 }}. <b> {{ grade.name }}</b></p>
                </div>
                <div class="col d-flex justify-content-between">
                    <a href="#"><b>Score List</b></a>
                    <a href="#"><b>Attendance List</b></a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            gradeTen: [
                { name: "Grade 10A" },
                { name: "Grade 10B" },
                { name: "Grade 10C" },
                { name: "Grade 10D" },
                { name: "Grade 10E" },
            ],
            gradeEleven: [
                { name: "Grade 11A" },
                { name: "Grade 11B" },
                { name: "Grade 11C" },
                { name: "Grade 11D" },
                { name: "Grade 11E" },
            ],
            gradeTwelve: [
                { name: "Grade 12A" },
                { name: "Grade 12B" },
                { name: "Grade 12C" },
                { name: "Grade 12D" },
                { name: "Grade 12E" },
            ],
        }
    }
}
</script>
<style scoped>
.class-container {
    margin: 30px;
}

.classes {
    display: flex;
    justify-content: space-evenly;
}

.card {
    width: 20%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
}

.grade-ten {

    padding: 0 30px 0 30px;
    margin: 20px 0 20px 0;
    border-radius: 10px;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
}

.row {
    display: flex;
    justify-content: space-between;
}
.col a {
    text-decoration: none;
    color: orange;
}

.col a:hover {
    color: rgb(79, 79, 250);
}
</style>

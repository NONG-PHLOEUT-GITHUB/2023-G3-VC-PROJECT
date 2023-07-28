<template>
    <teacher-dashboard></teacher-dashboard>
    <div class="main">
        <StudentMostAbsenceVue></StudentMostAbsenceVue>
    </div>
</template>

<script>
import StudentMostAbsenceVue from '../Student/StudentMostAbsence.vue';
export default {
    components :{
        StudentMostAbsenceVue
    }
}
</script>

<style scoped>
.main{
    width: 80%;
    margin-left: 18%;
}
</style>
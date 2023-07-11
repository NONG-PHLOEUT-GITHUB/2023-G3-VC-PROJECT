<template>
    <div class="card shadow border-0 m-4">
        <h3 class="text-primary mb-4">MONTHLY REPORTS OF CLASS 12A</h3>
        <div class="row">
            <div v-for="month of monthsList" :key="month" class="col-sm-4 mt-4">
                <div class="card bg-gray-300">
                    <div class="card-body d-flex flex-column align-items-center">
                    <h4 class="card-title">{{month.name}} REPORTS</h4>
                    <div class="btn-group">
                        <router-link  :to="{ path: '/student_list' }"><button type="button" class="btn text-primary-hover text-dark bg-gray-400 p-2 text-sm pl-4 pr-4"><i class="bi bi-table text-primary"></i> Table view</button></router-link>
                        <router-link  :to="{ path: '/student_list' }"><button type="button" class="btn text-primary-hover text-dark bg-gray-400 p-2 ml-4 text-sm pl-4 pr-4"><i class="bi bi-bar-chart-line-fill text-warning"></i> Graph view</button></router-link>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            monthsList: [
                {name: "JANUARY"},
                {name: "FEBRUARY"},
                {name: "MARCH"},
                {name: "APRIL"},
                {name: "MAY"},
                {name: "JUNE"},
                {name: "JULY"},
                {name: "AUGUST"},
                {name: "SEPTEMBER"},
                {name: "OCTOBER"},
                {name: "NOVEMBER"},
                {name: "DECEMBER"},
            ]
        }
    }
}
</script>

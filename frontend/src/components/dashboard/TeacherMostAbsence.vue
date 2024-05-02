<template>
   <v-data-table
    v-model:items-per-page="itemsPerPage"
    :headers="headers"
    :items="attendanceData"
    :items-length="attendanceData.length"
    :loading="loading"
    :search="search"
    item-value="name"
    class="elevation-1"
  >
    <template v-slot:item.profile="{ item }">
      <v-avatar size="large">
        <v-img :src="item.profile" alt="Avatar" cover> </v-img>
      </v-avatar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-btn :to="'/teacher-attendance/' + item.id + '/details'" icon="mdi-eye"></v-btn>
    </template>
  </v-data-table>
</template>
<script>
import htpp from '@/api/api'

export default {
  data() {
    return {
      attendanceData: []
    }
  },
  mounted() {
    htpp
      .get('/getTeacherMostAbsence')
      .then(response => {
        this.attendanceData = response.data
      })
      .catch(error => {
        console.log(error)
      })
  }
}
</script>

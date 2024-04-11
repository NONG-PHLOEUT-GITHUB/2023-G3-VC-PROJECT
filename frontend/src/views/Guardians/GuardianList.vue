<template>
  <custom-title></custom-title>
  <v-card class="pa-2 mb-4">
    <form class="form-inline my-2 my-lg-0 d-flex" style="width: 60%">
      <v-text-field />
    </form>
    <v-btn to="/add-guadian" color="teal-darken-4">
      Add new guardian <v-icon>mdi-plus-outline</v-icon></v-btn
    >
  </v-card>
  <v-data-table-server></v-data-table-server>
</template>

<script>
import swal from 'sweetalert'
import http from '@/api/api'

export default {
  data() {
    return {
      listGuardian: [],
      searchQuery: ''
    }
  },
  computed: {
    SearchGaurdian() {
      if (this.searchQuery === '') {
        return this.listGuardian
      } else {
        const filtered = this.listGuardian.filter(guardian =>
          (guardian.first_name + ' ' + guardian.last_name)
            .toLowerCase()
            .includes(this.searchQuery.trim().toLowerCase())
        )
        return filtered
      }
    }
  },
  methods: {
    getGuardian() {
      http.get('/getGuardians').then(response => {
        this.listGuardian = response.data.data
      })
    },
    deleteUser(id) {
      swal({
        title: 'Are you sure?',
        text: 'You will not be able to recover this guardian!',
        icon: 'warning',
        buttons: ['Cancel', 'Yes, delete it!'],
        dangerMode: true
      }).then(willDelete => {
        if (willDelete) {
          http
            .delete('/Guardians' + `/${id}`)
            .then(() => {
              swal('Deleted!', 'The guardian has been deleted.', 'success')
              // call mounted
              this.getGuardian()
            })
            .catch(error => {
              swal('Error', 'An error occurred while deleting the guardian.', 'error')
              console.error(error)
            })
        } else {
          swal('Cancelled', 'Your guardian is safe :)', 'error')
        }
      })
    }
  },
  mounted() {
    this.getGuardian()
  }
}
</script>

<style scoped>

</style>

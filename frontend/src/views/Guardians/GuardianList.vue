<template>
  <custom-title icon="mdi-human-male-girl">
    <template #right>
      <v-btn
        icon="mdi-filter-multiple-outline"
        variant="tonal"
        class="me-2 bg-primary"
        @click="toggleFilter = !toggleFilter"
      ></v-btn>
      <v-btn
        variant="tonal"
        class="me-2 bg-deep-orange-accent-4"
        icon="mdi-file-pdf-box"
        @click="downloadPDF()"
      ></v-btn>
      <v-btn variant="tonal" class="me-2 bg-green-darken-1" icon="mdi-file-excel"></v-btn>
    </template>
  </custom-title>
  <filter-guardian v-show="toggleFilter" />
  <v-card class="mb-4 elevation-0">
    <v-btn to="/add-guadian" color="teal-darken-4">
      Add new guardian <v-icon>mdi-plus-outline</v-icon></v-btn
    >
  </v-card>
  <v-data-table-server
    v-model:items-per-page="itemsPerPage"
    :headers="headers"
    :items="SearchGaurdian"
    :items-length="SearchGaurdian.length"
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
  </v-data-table-server>
</template>

<script>
import http from '@/api/api'
import FilterGuardian from '@/components/filters/FilterGuardian.vue'
export default {
  components: {
    FilterGuardian
  },
  data() {
    return {
      listGuardian: [],
      searchQuery: '',
      itemsPerPage: 10,
      toggleFilter: false,
      headers: [
        {
          title: 'Profile',
          align: 'start',
          sortable: false,
          key: 'profile'
        },
        {
          title: 'First name',
          align: 'start',
          sortable: false,
          key: 'first_name'
        },
        {
          title: 'Last name',
          align: 'start',
          sortable: false,
          key: 'last_name'
        },
        { title: 'Gender', key: 'gender', align: 'end' },
        { title: 'Email', key: 'email', align: 'end' },
        { title: '', key: 'actions', align: 'end' }
      ]
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
    deleteUser(id) {}
    // .then(willDelete => {
    //     if (willDelete) {
    //       http
    //         .delete('/Guardians' + `/${id}`)
    //         .then(() => {

    //         })
    //         .catch(error => {
    //           console.error(error)
    //         })
    //     } else {

    //     }
    //   })
    // }
  },
  mounted() {
    this.getGuardian()
  }
}
</script>

<style scoped></style>

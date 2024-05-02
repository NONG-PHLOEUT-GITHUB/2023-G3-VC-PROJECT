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
  <v-data-table
    v-model:items-per-page="options.itemsPerPage"
    :headers="headers"
    :items-length="guardians.length"
    :items="guardians"
    :loading="loading"
    item-value="name"
    class="elevation-1"
    >

    <template v-slot:item.profile="{ item }">
      <v-avatar size="large">
        <v-img :src="item.profile" alt="Avatar" cover> </v-img>
      </v-avatar>
    </template>
    <template v-slot:item.actions="{ item }">
        <v-btn
          :to="{ path: '/guardian/' + item.id + '/edit' }"
          variant="text"
          icon="mdi-pencil"
        ></v-btn>

        <v-btn @click="removeGuardian(item.id)" variant="text" icon="mdi-delete-forever" color="red">
        </v-btn>
      </template>
  </v-data-table>
</template>

<script>
import FilterGuardian from '@/components/filters/FilterGuardian.vue'
import { mapActions, mapState } from 'pinia'
import { useGuardianStore } from '@/stores/guardian'
export default {
  components: {
    FilterGuardian
  },
  created() {
    this.getAllGuardian()
  },
  data() {
    return {
      listGuardian: [],
      searchQuery: '',
      options: {
        itemsPerPage: 10,
        page: 1,
        sortBy: [],
        sortDesc: []
      },
      loading: false,
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
        { title: 'Phone number', key: 'phone_number', align: 'end' },
        { title: '', key: 'actions', align: 'end', sortable: false}
      ]
    }
  },
  computed: {
    ...mapState(useGuardianStore, ['guardians'])

  },
  methods: {
    ...mapActions(useGuardianStore, ['getAllGuardian','deleteGuardianByID']),
    removeGuardian(id){
      this.deleteGuardianByID(id);
      this.getAllGuardian()
    }
  },

}
</script>

<style scoped></style>

<template>
  <custom-title icon="mdi-human-male-girl">
    <template #right>
      <v-btn
        variant="outlined"
        append-icon="mdi-filter-multiple-outline"
        class="text-none me-4"
        color="primary"
        @click="toggleFilter = !toggleFilter"
        >Filters
      </v-btn>
      <v-btn variant="tonal" class="me-2 bg-green-darken-1" icon="mdi-file-excel"></v-btn>
    </template>
  </custom-title>
  <filter-guardian v-show="toggleFilter" />
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
        { title: '#ID', key: 'id' },
        {
          title: 'Profile',
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
          key: 'last_name'
        },
        {
          title: 'Gender',
          key: 'gender',
          sortable: false,
          align: 'end'
        },
        {
          title: 'Phone number',
          key: 'phone_number',
          align: 'end'
        },
        {
          title: 'Telegram',
          key: 'chatId',
          align: 'end',
          sortable: false
        },
        { title: '', key: 'actions', align: 'end' }
      ]
    }
  },
  computed: {
    ...mapState(useGuardianStore, ['guardians'])
  },
  methods: {
    ...mapActions(useGuardianStore, ['getAllGuardian', 'deleteGuardianByID']),
    removeGuardian(id) {
      this.deleteGuardianByID(id).then(response => {
        if (response.status == 200) {
          this.$root.$notif('Delete successfully', {
            type: 'success',
            color: 'primary'
          })
        }
      })
      this.getAllGuardian()
    }
  }
}
</script>

<style scoped></style>

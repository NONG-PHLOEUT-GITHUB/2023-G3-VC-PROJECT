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
      <v-btn variant="tonal" class="bg-green-darken-1" icon="mdi-file-excel"></v-btn>
      <v-btn
        v-if="this.selectedItem.length > 0"
        variant="tonal"
        class="ms-4 bg-deep-orange-accent-4"
        icon="mdi-delete-forever"
        @click="deleteMultiple"
      ></v-btn>
    </template>
  </custom-title>
  <filter-guardian v-show="toggleFilter" />
  <v-data-table
    v-model="selectedItem"
    :headers="headers"
    :items="guardians"
    :loading="loading"
    item-value="id"
    show-select
    class="elevation-1"
    hover
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
      selectedItem: [],
      loading: false,
      toggleFilter: false,
      headers: [
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
    ...mapActions(useGuardianStore, [
      'getAllGuardian',
      'deleteGuardianByID',
      'deleteMultipleGuardians'
    ]),
    removeGuardian(id) {
      this.deleteGuardianByID(id).then(response => {
        if (response.status == 200) {
          this.$root.$notif('Delete successfully', {
            type: 'success',
            color: 'primary'
          })
        }
        this.getAllGuardian()
      })
    },
    deleteMultiple() {
      this.deleteMultipleGuardians(this.selectedItem).then(response => {
        if (response.status == 200) {
          this.$root.$notif('Delete successfully', {
            type: 'success',
            color: 'primary'
          })
          this.getAllGuardian()
        }
        this.selectedItem = []
      })
    }
  }
}
</script>

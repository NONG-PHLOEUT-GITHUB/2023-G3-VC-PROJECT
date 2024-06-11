<template>
  <custom-title icon="mdi-comment-alert-outline">
    <template #right>
      <v-btn
        variant="outlined"
        append-icon="mdi-filter-multiple-outline"
        class="text-none me-4"
        color="primary"
        @click="toggleFilter = !toggleFilter"
        >{{ $t('btn.filter') }}
      </v-btn>
    </template>
  </custom-title>
  <v-card class="elevation-1 pa-3" v-show="toggleFilter">
    <v-row>
      <v-col>
        <v-text-field label="Teacher name" hide-details variant="outlined"></v-text-field>
      </v-col>
      <v-col>
        <v-text-field label="Title" hide-details variant="outlined"></v-text-field>
      </v-col>
    </v-row>
  </v-card>
  <v-col v-for="file in studentComments" v-if="studentComments.length != 0">
    <v-card>
      <template v-slot:prepend>
        <v-avatar>
          <v-img color="white" :src="file.profile"></v-img>
        </v-avatar>
      </template>
      <template v-slot:title>
        <v-card-title class="ms-3">{{ file.first_name + ' ' + file.last_name }}</v-card-title>
      </template>
      <template v-slot:subtitle> <span class="ms-3">{{ file.title }}</span> </template>

      <v-card-text class="pa-4">
        <v-chip>{{ file.body }}</v-chip>
      </v-card-text>
      <template v-slot:append>
        <v-btn icon="mdi-reply" variant="text"></v-btn>
      </template>
    </v-card>
  </v-col>
  <v-alert v-else text="Donn't have comments yet." type="info"></v-alert>
</template>
<script>
import { mapActions, mapState } from 'pinia'
import { useAuthStore } from '@/stores/auth'
export default {
  name: 'CommentStudentView',
  data() {
    return {
      toggleFilter: false
    }
  },
  created() {
    this.fetchUser()
  },
  computed: {
    ...mapState(useAuthStore, ['studentComments'])
  },
  methods: {
    ...mapActions(useAuthStore, ['fetchUser'])
  }
}
</script>

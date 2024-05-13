<template>
  <custom-title icon="mdi-comment-alert-outline">
    <template #right>
      <v-btn
        icon="mdi-filter-multiple-outline"
        variant="tonal"
        class="me-2 bg-primary"
        @click="toggleFilter = !toggleFilter"
      ></v-btn>
    </template>
  </custom-title>
  <v-card class="elevation-1 pa-3" v-show="toggleFilter">
    <v-row>
      <v-col>
        <v-text-field
          label="Teacher name"
          hide-details
          variant="outlined"
        ></v-text-field>
      </v-col>
      <v-col>
        <v-text-field
          label="Title"
          hide-details
          variant="outlined"
        ></v-text-field>
      </v-col>
    </v-row>
  </v-card>
  <v-card class="mt-2" v-if="studentComments.length != 0">
    <v-list :items="items" lines="three" item-props>
      <v-list-item
        v-for="file in studentComments"
        :key="file.title"
        :title="file.first_name  + ' ' + file.last_name"
        :subtitle="file.title"
      >
        <span>{{ file.body }}</span>
        <v-divider></v-divider>
        <template v-slot:prepend>
          <v-avatar>
            <v-img color="white" :src="file.profile"></v-img>
          </v-avatar>
        </template>

        <template v-slot:append>
          <v-btn icon="mdi-reply" variant="text"></v-btn>
        </template>
      </v-list-item>
    </v-list>
  </v-card>
  <v-alert v-else text="Donn't have comments yet." type="info"></v-alert>
</template>
<script>
import { mapActions,mapState } from 'pinia';
import { useAuthStore } from '@/stores/auth';
export default {
  name: 'CommentStudentView',
  data() {
    return {
      toggleFilter:false,
    }
  },
  created(){
    this.fetchUser()
  },
  computed:{
    ...mapState(useAuthStore,['studentComments'])
  },
  methods: {
    ...mapActions(useAuthStore,['fetchUser'])
  },
}
</script>


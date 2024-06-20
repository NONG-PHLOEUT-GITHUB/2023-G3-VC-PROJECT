<template>
  <custom-title icon="mdi-comment-alert-outline">
    <template #right>
      <v-btn
        variant="outlined"
        append-icon="mdi-filter-multiple-outline"
        class="text-none"
        color="primary"
        @click="toggleFilter = !toggleFilter"
      >
        {{ $t('btn.filter') }}
      </v-btn>
    </template>
  </custom-title>
  <v-card class="elevation-1 pa-3 mb-1" v-show="toggleFilter">
    <v-row>
      <v-col>
        <v-text-field
          label="Teacher name"
          hide-details
          variant="outlined"
          density="compact"
          color="textField"
        ></v-text-field>
      </v-col>
      <v-col>
        <v-text-field
          density="compact"
          label="Title"
          hide-details
          variant="outlined"
          color="textField"
        ></v-text-field>
      </v-col>
    </v-row>
  </v-card>
  <v-list :lines="false" elevation="0" v-if="studentComments.length != 0">
    <v-list-item
      v-for="(comment, i) in studentComments"
      :key="i"
      :value="comment"
      class="item mt-1"
      rounded="lg"
      elevation="0"
    >
      <!-- <v-list-subheader v-text="comment.title"></v-list-subheader> -->
      <template v-slot:prepend>
        <v-avatar>
          <v-img color="white" :src="comment.profile"></v-img>
        </v-avatar>
      </template>
      <v-list-item-title>
        {{ comment.first_name + ' ' + comment.last_name }}
      </v-list-item-title>
      <v-list-item-subtitle>
        {{ formatDate(comment.created_at) }}
      </v-list-item-subtitle>
      <v-list-item class="pa-0">
        {{ comment.body }}
      </v-list-item>
      <template v-slot:append>
        <v-btn icon="mdi-reply" variant="text"></v-btn>
      </template>
    </v-list-item>
  </v-list>
  <v-alert v-else text="Donn't have comments yet." type="info"></v-alert>
</template>
<script>
  import { mapActions, mapState } from 'pinia'
  import { useAuthStore } from '@/stores/auth'
  import { format, parseISO } from 'date-fns'

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
      ...mapActions(useAuthStore, ['fetchUser']),
      formatDate(dateString) {
        try {
          const date = parseISO(dateString)
          return format(date, 'dd-MMM-yyyy')
        } catch (error) {
          console.error('Error parsing date:', error)
          return dateString // Fallback to the original string if parsing fails
        }
      }
    }
  }
</script>

<style scoped>
.item{
  border: solid 1px #89474b;
}
</style>
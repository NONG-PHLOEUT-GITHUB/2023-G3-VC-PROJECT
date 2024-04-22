<template>
  <custom-title></custom-title>
  <v-card>
    <v-col>
      <v-row class="pa-2">
        <v-text-field label="Label" variant="outlined"></v-text-field>
        <v-text-field label="Label" variant="outlined"></v-text-field>
      </v-row>
    </v-col>
  </v-card>
  <v-card class="mt-2">
    <v-list :items="items" lines="three" item-props>
      <!-- <v-list-subheader inset>Files</v-list-subheader> -->

      <v-list-item
        v-for="file in items"
        :key="file.title"
        :subtitle="file.subtitle"
        :title="file.title"
      >
      <span>{{ file.body }}</span>
        <v-divider ></v-divider>
        <template v-slot:subtitle="{ subtitle }">
          <div v-html="subtitle"></div>
        </template>
        <template v-slot:prepend>
          <v-avatar>
            <v-img color="white" :src="file.prependAvatar"></v-img>
          </v-avatar>
        </template>

        <template v-slot:append>
          <v-btn icon="mdi-reply" variant="text"></v-btn>
        </template>
      </v-list-item>
    </v-list>
  </v-card>
</template>
<script>
import http from '@/api/api'
import Cookies from 'js-cookie'
export default {
  name: 'UserDetails',
  data() {
    return {
      comments: ' ',
      role: '',
      items: [
        {
          prependAvatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg',
          title: 'Brunch ',
          subtitle: 'Brunch this weekend?',
          body: `Ali Connors  I'll be in your neighborhood doing errands this weekend. Do you want to hang out?`
        },
        {
          prependAvatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg',
          title: 'Brunch Kalusa',
          subtitle: 'Brunch this weekend?',
          body: `Ali Connors  I'll be in your neighborhood doing errands this weekend. Do you want to hang out?`
        },
        {
          prependAvatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg',
          title: 'Brunch Kalusa',
          subtitle: 'Brunch this weekend?',
          body: `Ali Connors  I'll be in your neighborhood doing errands this weekend. Do you want to hang out?`
        }
      ]
    }
  },
  methods: {
    fetchData() {
      // http.get('/v1/auth/user').then(response => {
      //   this.comments = response.data.data.comments
      //   console.log('comment', this.comments)
      // })
    },
    getRole() {
      let cookies = Cookies.get('user_role')
      this.role = cookies
    }
  },

  mounted() {
    this.fetchData()
    this.getRole()
  }
}
</script>

<style>
.thead {
  background: #004d40;
}
.name {
  width: 15%;
}
</style>

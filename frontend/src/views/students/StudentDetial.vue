<template>
  <custom-title></custom-title>
  <v-card>
    <v-tabs
      v-model="tab"
      align-tabs="start"
      color="deep-purple-accent-4"
    >
      <v-tab :value="1">Account</v-tab>
      <v-tab :value="2">Info</v-tab>
      <v-tab :value="3">Comment</v-tab>
      <v-tab :value="3">Score</v-tab>
      <v-tab :value="3">Attendance</v-tab>
    </v-tabs>
    <v-window v-model="tab">
      <v-window-item
        v-for="n in 3"
        :key="n"
        :value="n"
      >
        <v-container fluid>
          <v-row>
            <v-col
              v-for="i in 6"
              :key="i"
              cols="12"
              md="4"
            >
              <v-img
                :lazy-src="`https://picsum.photos/10/6?image=${i * n * 5 + 10}`"
                :src="`https://picsum.photos/500/300?image=${i * n * 5 + 10}`"
                aspect-ratio="1"
              ></v-img>
            </v-col>
          </v-row>
        </v-container>
      </v-window-item>
    </v-window>
  </v-card>
</template>

<script>
import http from "@/api/api";

export default {
  name: "UserDetails",
  data() {
    return {
      users: [],
      reveal: false,
      comments: [],
      parents: [],
      teacherID: [],
      listUser: [],
    };
  },
  methods: {
    async getCommentByTeacher() {
      // try {
      //   const response = await http.get("/get-students");
      //   this.listUser = response.data.data;
      //   for (let user of this.listUser) {
      //     this.teacherID = user.id;
      //     const id = this.$route.params.id;
      //     const response = await http.get(
      //       `/get-comments-student/${id}/${this.teacherID}`
      //     );
      //     this.comments = response.data.comments;
      //     console.log(this.comments);
      //   }
      // } catch (error) {
      //   console.error(error);
      // }
    },
    fetchDataById(id) {
      // http
      //   .get(`/users/${id}`)
      //   .then((response) => {
      //     this.users = response.data.data;
      //     console.log(this.responseData);
      //   })
      //   .catch((error) => {
      //     console.error(error);
      //   });
    },

    getParents(id) {
      // http.get(`/getParents/${id}`).then((response) => {
      //   this.parents = response.data.guardian;
      //   console.log(this.parents);
      // });
    },
    getTeacherId() {
      // http.get("/get-students").then((response) => {
      //   this.listUser = response.data.data;
      //   for (let user of this.listUser) {
      //     this.teacherID = user.id;
      //     console.log(this.teacherID);
      //   }
      // });
    },
  },
  mounted() {
    const id = this.$route.params.id;
    this.fetchDataById(id);
    this.getCommentByTeacher();
    this.getParents(id);
    this.getTeacherId();
  },
};
</script>

<style scoped>
.detail {
  margin-left: 18%;
}

.imformation {
  display: flex;
  flex-direction: column;
}

.title {
  text-transform: uppercase;
  font-weight: bold;
}
.img-fluid {
  border: solid 3px #e0caca;
}

.imformation {
  display: flex;
  flex-direction: column;
}

.title {
  text-transform: uppercase;
  font-weight: bold;
}
.img-fluid {
  border: solid 3px #e0caca;
}
.v-card--reveal {
  bottom: 0;
  opacity: 1 !important;
  position: absolute;
  width: 100%;
}
.box {
  margin-left: 27%;
}
</style>

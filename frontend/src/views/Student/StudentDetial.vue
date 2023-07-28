<template>
  <admin-dashboard></admin-dashboard>
  <v-sheet
    border="lg opacity-12"
    class="detail mt-6"
    elevation="4"
    height="auto"
    rounded
    max-width="80%"
  >
    <v-container fluid>
      <v-row>
        <v-col cols="12" md="3">
          <v-img
            :src="users.profile"
            alt="Avatar"
            class="img-fluid my-7 w-75 rounded-circle ms-10"
            height="200"
            cover
          >
          </v-img>
          <v-title class="title ms-20">
            {{ users.first_name }} {{ users.last_name }}</v-title
          >

          <v-btn class="ms-10 mt-5">
            <v-icon size="24"> mdi-account-edit </v-icon>Change profile
          </v-btn>
        </v-col>

        <v-col cols="12" md="9">
          <v-col cols="auto" class="imformation">
            <v-btn block density="default  bg-teal-darken-4"
              ><v-icon> mdi-information </v-icon>Personal Information
            </v-btn>

            <v-card variant="text" class="mt-4">
              <v-icon class="me-2">mdi-account </v-icon>Full name :
              {{ users.first_name }} {{ users.last_name }}
            </v-card>

            <v-card variant="text mt-4">
              <v-icon class="me-2"> mdi-gender-transgender </v-icon>Gender :
              {{ users.gender }}
            </v-card>
            <v-card variant="text mt-4">
              <v-icon class="me-2"> mdi-calendar </v-icon>Date of birth :
              {{ users.date_of_birth }}
            </v-card>
            <v-card variant="text mt-4">
              <v-icon class="me-2"> mdi-numeric </v-icon>Age : {{ users.age }}
            </v-card>

            <v-btn block density="default mt-4 bg-teal-darken-4"
              ><v-icon>mdi-map-marker</v-icon> Contact Information</v-btn
            >

            <v-card variant="text mt-4">
              <v-icon class="me-2"> mdi-phone </v-icon>Phone number :
              {{ users.phone_number }}
            </v-card>
            <v-card variant="text mt-4">
              <v-icon class="me-2"> mdi-map-marker </v-icon>Address :
              {{ users.address }}
            </v-card>
            <v-card variant="text mt-4">
              <v-icon class="me-2"> mdi-email </v-icon>Email : {{ users.email }}
            </v-card>
          </v-col>
          <v-col cols="auto">
            <v-btn block density="default  bg-teal-darken-4">
              <v-icon class="me-2"> mdi-account </v-icon>Parent
              Information</v-btn
            >
            <div >
              <v-card variant="text" class="mt-4">
                <v-icon class="me-2">mdi-account </v-icon>Full name :
                {{ this.parents.first_name}}{{this.parents.last_name}}
              </v-card>
              <v-card variant="text" class="mt-4">
                <v-icon class="me-2">mdi-gender-transgender </v-icon>Gender :
                {{ this.parents.gender }}
              </v-card>
              <v-card variant="text mt-4">
                <v-icon class="me-2"> mdi-phone </v-icon>Phone number :
                {{ this.parents.phone_number }}
              </v-card>
              <v-card variant="text mt-4">
                <v-icon class="me-2"> mdi-map-marker </v-icon>Address :
                {{ this.parents.address }}
              </v-card>
            </div>
          </v-col>
        </v-col>
      </v-row>
    </v-container>
    <v-card class="ml-5 mb-5" max-width="340" elevation="4">
      <v-card-text v-for="comment in comments" :key="comment">
        <div class="text-h5 font-weight-bold">Feedback</div>
        <p class="text--primary">
          Comment by Teacher: {{ comment.teacher_fullname }}
        </p>
        <p class="text--primary">Body:{{ comment.body }}</p>
        <p></p>
      </v-card-text>
    </v-card>
  </v-sheet>
</template>
  
  <script>
import http from "@/htpp.common";

export default {
  name: "UserDetails",
  data() {
    return {
      users: [],
      reveal: false,
      comments: [],
      parents: [],
    };
  },
  methods: {
    fetchDataById(id) {
        http.get(`/users/${id}`)
            .then(response => {
            this.users = response.data.data;
            console.log(this.responseData);
            })
            .catch(error => {
            console.error(error);
            });
        },
    getParents(id) {
      http.get(`/getParents/${id}`).then((response) => {
        this.parents = response.data.guardian
        console.log(this.parents);
      });
    },
    getCommentByTeacher() {
      http.get("/getComments").then((response) => {
        this.comments = response.data.data;
      });
    },
  },

  mounted() {
   const id = this.$route.params.id;
    this.getParents(id);
    this.getCommentByTeacher();
    this.fetchDataById(id);
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
</style>
  
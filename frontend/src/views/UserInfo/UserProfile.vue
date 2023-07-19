<template>
  <student-dashboard></student-dashboard>
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
          <!-- {{ users.first_name }} {{ users.last_name }} -->
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
          </v-col>
        </v-col>
      </v-row>
    </v-container>
  </v-sheet>
</template>

<script>
import http from "@/htpp.common";

export default {
  name: "UserDetails",
  data() {
    return {
      users: " ",
    };
  },
  methods: {
    fetchData() {
      http.get("/api/v1/auth/user").then((response) => {
        this.users = response.data.data;
      });
    },
  },

  mounted() {
    this.fetchData();
  },
};
</script>

<style>
.detail {
  margin-left: 18%;
}

.imformation {
  display: flex;
  flex-direction: column;
}
</style>

<template>
  <admin-dashboard></admin-dashboard>
  <div class="main">
    <!-- <h3 class="mb-0 text-primary mt-4">CLASSES LIST</h3> -->
    <v-card class="d-flex mt-5 pa-5">

      <!-- <v-row> -->
        <v-select class="w-10"
        label="Select class"
        :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
        variant="solo"
        ></v-select>
        <v-btn color="primary" class="mt-4 ms-5" @click="dialog=true"><v-icon>mdi-plus-outline</v-icon> add new class</v-btn>
      <!-- </v-row> -->

      <v-row justify="center">
        <v-dialog v-model="dialog" persistent width="40%">
          <v-card>
            <v-card-title>
              <span class="text-h5">Create new class</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>

                  <v-col cols="12">
                    <v-text-field 
                    v-modle="className"
                    label="Class name" 
                    required variant="outlined"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field 
                    v-model="teacherName"
                    variant="outlined"
                    label="Teacher name"
                    required
                    >
                  </v-text-field>
                  </v-col>
                  
                </v-row>
              </v-container>
    
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="blue-darken-1"
                variant="text"
                @click="dialog = false"
              >
                Close
              </v-btn>
              <v-btn type="submit"
                color="blue-darken-1"
            
                @click="addClass"
              >
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-row>
    </v-card>

    <v-card
      v-for="classRoom in listClasses"
      :key="classRoom.name"
      class="card mx-auto mt-2"
      width="96%"
      prepend-icon="mdi-home"
    >
      <template v-slot:title> Class : {{ classRoom.class_name }} </template>

      <v-col cols="auto">
        <v-btn to="/monthly_report" class="me-4">
       <v-icon>mdi-chart-line</v-icon>   Score report
        </v-btn>
        <v-btn to="/attendance_list">
         <v-icon>mdi-calendar-clock</v-icon> Attendance report</v-btn>
        <v-btn to="/feedback" class="ms-4">
        <v-icon>mdi-poll</v-icon>  Studen feedback
        </v-btn>
       

      </v-col>

      <!-- <v-card-text>
          This is content
        </v-card-text>  -->
    </v-card>
  </div>
</template>

<script>

import http from "@/htpp.common";

export default {
  data() {
    return {
      students: [],
      listClasses: [],
      numberStudent: 0,
      searchQuery: "",
      selectedClass: "",
      dialog: false,

      teachers: [],
      className: "",
      teacherName: "",
    };
  },

  methods: {
    getURL() {
      http.get("/api/classes").then((response) => {
        this.listClasses = response.data.data;
        console.log(this.listClasses);
      });
    },
    showStudents() {
      http
        .get('api/getuserInClass')
        .then((response) => {
          console.log(response.data);
          this.error = null;
        })
        .catch((error) => {
          this.studentName = null;
          this.error = error.response.data.error;
        });
    },


    addClass() {
      if (this.class_name && this.teacher) {
        const newClass = {
          class_name: this.class_name,
          teacher: this.teacher.first_name,
        };
        http.post('/api/classes', newClass)
        .then((response) => {
          console.log(response.data);
          this.dialog = false;
        });
      }
    },
  },
  mounted() {
    http.get('/api/getTeachers')
    .then((response) => {
      this.teachers = response.data;
    })
    .catch((error) => {
      console.log(error);
    });
    return this.getURL();
  },
}
</script>

<style scoped>
@import "~vuetify/dist/vuetify.css";
.main {
  margin-left: 18%;
  margin-top: 15px;
}
</style>
<template>
  <div class="main">
    <h3 class="mb-0 text-primary mt-4">CLASSES LIST</h3>
    <v-card class="d-flex mt-5 pa-5">
      <v-select
        class="w-10"
        label="Select class"
        :items="listClasses && listClasses.map((classRoom) => classRoom.class_name)"
        v-model="selectedClass"
        variant="solo"
        @click="showStudents(selectedClass)"
      ></v-select>
      <v-btn color="primary" class="mt-4 ms-5" @click="dialog = true"
        ><v-icon>mdi-plus-outline</v-icon> add new class</v-btn
      >
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
                      v-model="className"
                      label="Class name"
                      required
                      variant="outlined"
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
              <v-btn type="submit" color="blue-darken-1" @click="addClass">
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-row>
    </v-card>

    <template v-if="listClasses && listClasses.length">
      <v-card
        v-for="classRoom in listClasses"
        :key="classRoom.class_id"
        class="card mx-auto mt-2"
        width="96%"
        prepend-icon="mdi-home"
      >
        <template v-slot:title> Class : {{ classRoom.class_name }} </template>

        <v-col cols="auto">
          <v-btn to="/monthly_report" class="me-4">
            <v-icon>mdi-chart-line</v-icon> Score report
          </v-btn>
          <v-btn to="/attendance-list"  @click="showStudents(className)" class="ms-4">
            <v-icon>mdi-poll</v-icon> Attendance Report
          </v-btn>
          <v-btn to="/feedback" class="ms-4">
            <v-icon>mdi-poll</v-icon> Student feedback
          </v-btn>
        </v-col>
      </v-card>
    </template>
  </div>
</template>

<script>
import http from "@/htpp.common";

export default {
  data() {
    return {
      listClasses: [],
      selectedClass: "",
      dialog: false,
      className: "",
      teacherName: "",
      listUser: [],
    };
  },

  methods: {
    getURL() {
      http.get("/api/classrooms").then((response) => {
        this.listClasses = response.data.data;
        console.log(this.listClasses);
      });
    },

    showStudents(classId) {
      http
        .get(`api/getuserInClass/${classId}`)
        .then((response) => {
          console.log(classId);
          this.listUser = response.data;
          console.log(this.listUser);
        })
        .catch((error) => {
          this.listUser = [];
          console.log(error.response.data.error);
        });
    },

    addClass() {
      if (this.className && this.teacherName) {
        const newClass = {
          class_name: this.className,
          teacher: this.teacherName,
        };
        http.post("/api/classrooms", newClass).then((response) => {
          console.log(response.data);
          this.dialog = false;
          this.getURL();
        })
        .catch(error=>{
          console.log(error);
        });
      }
    },
  },

  mounted() {
    http
      .get("/api/getTeachers")
      .then((response) => {
        this.teachers = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
    this.getURL();
  },
};
</script>
<style scoped>
@import "~vuetify/dist/vuetify.css";
.main {
  margin-left: 18%;
  margin-top: 15px;
}
</style>
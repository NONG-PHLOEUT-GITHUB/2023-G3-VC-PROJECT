<template>
  <admin-dashboard></admin-dashboard>
  <div class="main">
    <!-- <h3 class="mb-0 text-primary mt-4">CLASSES LIST</h3> -->
    <v-card class="d-flex mt-5 pa-5">
      <!-- <v-row> -->
      <v-select
        class="w-10"
        label="Select class"
        :items="[
          'California',
          'Colorado',
          'Florida',
          'Georgia',
          'Texas',
          'Wyoming',
        ]"
        variant="solo"
      ></v-select>
      <v-btn color="primary" class="mt-4 ms-5" @click="dialog = true"
        ><v-icon>mdi-plus-outline</v-icon> add new class</v-btn
      >
      <!-- </v-row> -->

      <v-row justify="center">
        <v-dialog v-model="dialog" persistent width="40%">
          <v-card>
            <v-form @submit.prevent="saveClassroom">
              <v-card-title>
                <span class="text-h5">{{ formAction }}</span>
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
                    
                      <!-- <v-select
                          v-model="selectedTeacher"
                          :items="teachers"
                          :item-text="teacherName"
                          item-value="user_id"
                          label="Select teacher"
                          variant="outlined"
                          
                        >
                      </v-select> -->
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
                  >Cancel</v-btn
                >
                <v-btn type="submit" color="blue-darken-1">Save</v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-dialog>
      </v-row>
    </v-card>

    <v-card
      v-for="classroom in classrooms"
      :key="classroom.id"
      class="card mx-auto mt-2"
      width="96%"
      prepend-icon="mdi-home"
    >
      <template v-slot:title> Class : {{ classroom.class_name }} </template>
      <div class="action">
        <v-col cols="auto">
          <v-btn to="/monthly_report" class="me-4">
            <v-icon>mdi-chart-line</v-icon> Score report
          </v-btn>
          <v-btn to="/attendance_list">
            <v-icon>mdi-calendar-clock</v-icon> Attendance report</v-btn
          >
          <v-btn to="/feedback" class="ms-4">
            <v-icon>mdi-poll</v-icon> Studen feedback
          </v-btn>
        </v-col>
        <v-col class="manage">
          <v-btn @click="editClassroom(classroom)" color="green" class="me-2">
            <v-icon>mdi-pencil</v-icon>Edit
          </v-btn>
          <v-btn
            @click="deleteClassroom(classroom.id)"
            color="red"
            class="text-white"
          >
            <v-icon>mdi-delete</v-icon> Delete
          </v-btn>
        </v-col>
      </div>
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
      numberStudent: 0,
      searchQuery: "",
      selectedClass: "",

      dialog: false,
      teachers: [],
      selectedTeacher: null,
      classrooms: [],
      className: "",
      formAction: "Add Classroom",
      editing: false,
      editId: null,
      users: [
          {
            id: 1,
            name: "John",
            last: "Doe"
          },
          {
            id: 2,
            name: "Harry",
            last: "Potter"
          },
          {
            id: 3,
            name: "George",
            last: "Bush"
          }
        ]
    };
  },

  computed: {
    teacherName() {
      return function (teacher) {
        return teacher.first_name + " " + teacher.last_name;
      };
    },
  },

  methods: {
    showStudents() {
      http
        .get("api/getuserInClass")
        .then((response) => {
          console.log(response.data);
          this.error = null;
        })
        .catch((error) => {
          this.studentName = null;
          this.error = error.response.data.error;
        });
    },

    getTeacher() {
      http
        .get("/api/get-teachers")
        .then((response) => {
          if (response.data && response.data.data) {
            let teacherList = response.data.data;
            for (let teacher of teacherList) {
              // this.teachers.push(teacher.first_na  me + " " + teacher.last_name);
              // this.teachers.push(teacher.id)
              this.teachers.push({
                text: teacher.first_name + " " + teacher.last_name,
                value: teacher.id,
              });
            }
            console.log(this.teachers);
          } else {
            console.log("Invalid response format:", response);
          }
        })
        .catch((error) => {
          console.log("Error fetching teachers:", error);
        });
    },
    onTeacherSelected(teacher) {
      // this.selectedTeacher = teacher.text;
      this.selectedTeacher = teacher.value;
    },

    fetchClassrooms() {
      http.get("/api/classrooms").then((response) => {
        this.classrooms = response.data.data;
        // console.log(this.listClasses);
      });
    },

    saveClassroom() {
      // Create a new classroom object with the selected teacher object and other form data
      const newclassroom = {
        class_name: this.className,
        user_id: this.selectedTeacher,
      };

      if (this.editing) {
        // Update an existing classroom
        http
          .put(`/api/classrooms/${this.editId}`, newclassroom)
          .then(() => {
            // Reset the form and close the dialog
            this.cancelForm();
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        // Add a new classroom
        http
          .post("/api/classrooms", newclassroom)
          .then(() => {
            // Reset the form and close the dialog
            this.cancelForm();
            this.fetchClassrooms();
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },

    editClassroom(classroom) {
      this.formAction = "Edit Classroom";
      this.editing = true;
      this.editId = classroom.id;
      this.classroom = { ...classroom };
      this.selectedTeacher = classroom.teacherId;
      this.dialog = true;
    },

    cancelForm() {
      this.formAction = "Add Classroom";
      this.editing = false;
      this.editId = null;
      this.classroom = { className: "", teacher: "" };
      this.selectedTeacher = null;
      this.dialog = false;
    },

    deleteClassroom(id) {
      http
        .delete(`/api/classrooms/${id}`)
        .then(() => {
          const index = this.classrooms.findIndex((c) => c.id === id);
          if (index !== -1) {
            this.classrooms.splice(index, 1);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  mounted() {
    this.fetchClassrooms();
    this.getTeacher();
  },
};
</script>

<style scoped>
@import "~vuetify/dist/vuetify.css";
.main {
  margin-left: 18%;
  margin-top: 15px;
}
.action {
  display: flex;
}
.manage {
  display: flex;
  justify-content: flex-end;
}
</style>

<template>
  <div class="card shadow border-0 mb-7">
    <div class="table-responsive">
      <table class="table table-hover table-nowrap">
        <thead class="bg-primary">
          <tr>
            <th scope="col" class="fs-6 text-light">Name</th>
            <th scope="col" class="fs-6 text-light">K</th>
            <th scope="col" class="fs-6 text-light">M</th>
            <th scope="col" class="fs-6 text-light">P</th>
            <th scope="col" class="fs-6 text-light">E</th>
            <th scope="col" class="fs-6 text-light">B</th>
            <th scope="col" class="fs-6 text-light">ES</th>
            <th scope="col" class="fs-6 text-light">CH</th>
            <th scope="col" class="fs-6 text-light">GEO</th>
            <th scope="col" class="fs-6 text-light">H</th>
            <th scope="col" class="fs-6 text-light">MC</th>
            <th scope="col" class="fs-6 text-light">SP</th>
            <th scope="col" class="fs-6 text-light">Total</th>
            <th scope="col" class="fs-6 text-light">Average</th>
          </tr>
        </thead>

        <tbody v-for="student of listUser" :key="student">
          <tr class="border-secondary">
            <td>
              <input
              class="form-check-input" 
                type="checkbox" 
                @click="getStudentId(student.id)"
                v-model="student.selected"
              />
              {{ student.first_name + " " }}{{ student.last_name }}
            </td>

            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.K"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.M"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.P"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.E"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.B"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.ES"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.CH"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.GEO"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.H"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.MC"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.SP"
              />
            </td>
            <td  >{{ getTotalScore(student)}}</td>
            <!-- <td>{{ getTotalScore() ? getTotalScore(student) : 0 }}</td> -->
            <td>{{ getAverageScore(student) }}</td>
           
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      listUser: [],
      URL: "http://127.0.0.1:8000/api/getStudents",
      subjectName: "",
      scoreLimit: 1,
    };
  },
  methods: {
    // get all student
    getStudent() {
      axios.get(this.URL).then((response) => {
        this.listUser = response.data;
        // console.log(this.listUser);
      });
    },

    // get student id
    getStudentId(id) {
      axios
        .get(this.URL + "/" + `${id}`)
        .then((response) => {
          console.log(response.data.id);
        })
        .catch((error) => {
          console.error(error);
        });
    },

    getScore(student) {
      let scores = [];
      for (var subject in student) {
        if (typeof student[subject] === "number") {
          scores.push(student[subject]);
        }
      }
      return scores.pop();
    },
  },
  computed: {
    getTotalScore() {
      return function (student) {
        let total = 0;
        for (var score in student) {
          if (typeof student[score] === "number") {
              total += student[score]
            }
          }
          return total;
      };
    },
    getAverageScore() {
      return function (student) {
        let total = 0;
        let average=0;
        for (var score in student) {
          if (typeof student[score] === "number") {
              total += student[score]
              average = total/12
            }
          }
          return average;
      };

    }
  },
  mounted() {
    return this.getStudent();
  },
};
</script>

<style scoped>
.score_input {
  border: 1px solid rgb(97, 93, 93);
  padding: 7px;
  width: 50px;
}
</style>

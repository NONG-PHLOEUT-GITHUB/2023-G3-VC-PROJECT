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

        <tbody>
          <tr
            class="border-secondary"
            v-for="student in listUser"
            :key="student.id"
          >
            <td>
              <input
                class="form-check-input"
                type="checkbox"
                @click="getStudentId(student.id)"
                v-model="student.selected"
              />
              {{ student.first_name }} {{ student.last_name }}
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
            <td>{{ getTotalScore(student) }}</td>
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
    // get score form input number
    getScore(student) {
      let scores = [];
      for (var subject in student) {
        if (typeof student[subject] === "number") {
          scores.push(student[subject]);
        }
      }
      console.log(scores.pop());
      return scores;
    },
  },
  computed: {
    // compute total of score that we have been inputed
    getTotalScore() {
      return function (student) {
        let total = 0;
        const subjects = [
          "K",
          "M",
          "P",
          "E",
          "B",
          "ES",
          "CH",
          "GEO",
          "H",
          "MC",
          "SP",
        ];
        for (var i = 0; i < subjects.length; i++) {
          const subject = subjects[i];
          if (
            typeof student[subject] === "number" &&
            !isNaN(student[subject])
          ) {
            total += student[subject];
          }
        }
        return total;
      };
    },
    // get average score that we have been inputed 
    getAverageScore() {
      return function (student) {
        let total = this.getTotalScore(student);
        return (total / 12).toFixed(2);
      };
    },
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

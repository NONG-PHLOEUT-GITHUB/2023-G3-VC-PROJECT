<template>
  <div class="card shadow border-0 mb-7">
    <div class="table-responsive">
      <table class="table table-hover table-nowrap">
        <thead class="bg-primary">
          <tr>
            <th scope="col" class="fs-7 text-light">Name</th>
            <th scope="col" class="fs-7 text-light">Khmer</th>
            <th scope="col" class="fs-7 text-light">Math</th>
            <th scope="col" class="fs-7 text-light">English</th>
            <th scope="col" class="fs-7 text-light">History</th>
            <th scope="col" class="fs-7 text-light">Biology</th>
            <th scope="col" class="fs-7 text-light">Geography</th>
            <th scope="col" class="fs-7 text-light">Earth-Science</th>
            <th scope="col" class="fs-7 text-light">Morality-Civics</th>
            <th scope="col" class="fs-7 text-light">Chemistry</th>
            <th scope="col" class="fs-7 text-light">Physics</th>
            <th scope="col" class="fs-7 text-light">Sport</th>
            <th scope="col" class="fs-7 text-light">ICT</th>
            <th scope="col" class="fs-7 text-light">Total</th>
            <th scope="col" class="fs-7 text-light">Average</th>
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
                class="form-check-input "
                type="checkbox"
                @click="getStudentId(student.id)"
                v-model="student.selected"
              />
              {{ student.first_name }} {{ student.last_name }}
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input "
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
                v-model="student.E"
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
                v-model="student.B"
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
                v-model="student.ES"
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
                v-model="student.CH"
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
                v-model="student.SP"
              />
            </td>
            <td>
              <input
                type="number"
                class="form-control score_input"
                v-on:keyup="getScore(student)"
                v-model="student.ICT"
              />
            </td>
            <td>{{ getTotalScore(student) }}</td>
            <td>{{ getAverageScore(student) }}</td>
          </tr>
        </tbody>
      </table>
      <div class="d-flex align-items-end">
        <button type="submit" @click="SubmitScoreSubject" class="btn btn-primary text-white m-2 ">Submit Score</button>
      </div>
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
      id_user: 0,
      user_id: '',
      subject_id: '',
      score:'',
      subjectName:  "",
      subjects:[],
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
          this.id_user = response.data.id;
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
      return scores;
    },
    // submit score and subject to database
      SubmitScoreSubject() {
    // Map the subjects array to an array of objects with subject_name and subject_score properties
    const subjectsData = this.subjects.map(value => ({ subject_name: value.subject_name, subject_score: value.subject_score }));
    let subjectInput  = '';
    let scoreInput = 0;
    for(let value of subjectsData) {
      scoreInput = value.subject_score
      if(value.subject_name == "K"){
        subjectInput = 1;
      }else if (value.subject_name == "M"){
        subjectInput = 2;
      }else if (value.subject_name == "E"){
        subjectInput = 3;
      }else if (value.subject_name == "H"){
        subjectInput = 4;
      }else if (value.subject_name == "B"){
        subjectInput = 5;
      }else if (value.subject_name == "GEO"){
        subjectInput = 6;
      }else if (value.subject_name == "ES"){
        subjectInput = 7;
      }else if (value.subject_name == "MC"){
        subjectInput = 8;
      }else if (value.subject_name == "CH"){
        subjectInput = 9;
      }else if (value.subject_name == "P"){
        subjectInput = 10;
      }else if (value.subject_name == "SP"){
        subjectInput = 11;
      }else if (value.subject_name == "ICT"){
        subjectInput = 12;
      }
    }
    console.log(subjectInput);
  
    // Create an object with user_id and subjects properties
    const postData = {
      user_id: this.id_user,
      subject_id: subjectInput,
      score: scoreInput
    };
    // console.log(postData);
    
    // Send a POST request to the API endpoint with the postData as the request body
    axios.post('http://127.0.0.1:8000/api/scores', postData)
      .then((response) => {
        console.log(response.data);
      })
      .catch((error) => {
        console.error(error);
      });
  },
},
  computed: {
    // compute total of score that we have been inputed
    getTotalScore() {
  return function (student) {
    let total = 0;
    let subject_name = "";
    let subjectScore = "";
    const subjects = [
      "K",
      "M",
      "E",
      "H",
      "B",
      "GEO",
      "ES",
      "MC",
      "CH",
      "P",
      "SP",
      "ICT",
    ];
    for (var i = 0; i < subjects.length; i++) {
      const subject = subjects[i];
      if (
        typeof student[subject] === "number" &&
        !isNaN(student[subject])
      ) {
        subject_name = subjects[i];
        subjectScore = student[subject];
        total += student[subject];
        
        // Check if the subject already exists in the array
        const existingSubjectIndex = this.subjects.findIndex(s => s.subject_name === subject_name);
        if (existingSubjectIndex !== -1) {
          // Update the subject_score property of the existing object
          this.subjects[existingSubjectIndex].subject_score = subjectScore;
        } else {
          // Push a new object to the array
          this.subjects.push({
            subject_name: subject_name,
            subject_score: subjectScore
          });
        }
        
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
  padding: 6px;
  margin-left: -10%;
  width: 50px;
  height: 30px;
}
</style>

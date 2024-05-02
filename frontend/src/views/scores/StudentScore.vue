<template>
  <custom-title icon="mdi-scoreboard-outline">
    <template #right>
      <v-btn
        icon="mdi-filter-multiple-outline"
        variant="tonal"
        class="me-2 bg-primary"
        @click="toggleFilter = !toggleFilter"
      ></v-btn>
      <v-btn
        variant="tonal"
        class="me-2 bg-green-darken-1"
        icon="mdi-export-variant"
        @click="exportExcel()"
      ></v-btn>
      <v-btn
        variant="tonal"
        class="me-2 bg-green-darken-1"
        icon="mdi-file-excel"
        @click="sendAttendancStudentAsExecl()"
      ></v-btn>
    </template>
  </custom-title>

  <v-container fluid class="pa-0">
    <v-card class="mx-auto">
      <v-list lines="two">
        <!-- <v-list-subheader inset>Folders</v-list-subheader> -->

        <v-list-item
          v-for="folder in folders"
          :key="folder.title"
          :subtitle="folder.subtitle"
          :title="folder.title"
        >
          <template v-slot:prepend>
            <v-avatar color="grey-lighten-1">
              <v-icon color="white">mdi-folder</v-icon>
            </v-avatar>
          </template>

          <template v-slot:append>
            <v-btn color="grey-lighten-1" icon="mdi-information" variant="text"></v-btn>
          </template>
        </v-list-item>
      </v-list>
    </v-card>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    files: [
      {
        color: 'blue',
        icon: 'mdi-clipboard-text',
        subtitle: 'Jan 20, 2014',
        title: 'Vacation itinerary'
      },
      {
        color: 'amber',
        icon: 'mdi-gesture-tap-button',
        subtitle: 'Jan 10, 2014',
        title: 'Kitchen remodel'
      }
    ],
    folders: [
      {
        subtitle: 'Jan 9, 2014',
        title: 'Photos'
      },
      {
        subtitle: 'Jan 17, 2014',
        title: 'Recipes'
      },
      {
        subtitle: 'Jan 28, 2014',
        title: 'Work'
      }
    ]
  })
}
// import axios from 'axios'
// import http from '@/api/api'
// import LRU from 'lru-cache'

// const cache = new LRU(100)
// export default {
//   data() {
//     return {
//       listUser: [],
//       id_user: 0,
//       user_id: '',
//       subject_id: '',
//       score: '',
//       subjectName: '',
//       subjects: [],
//       classrooms: []
//     }
//   },
//   methods: {
//     // get all student
//     getStudent() {
//       axios.get(this.URL).then(response => {
//         this.listUser = response.data.data
//         console.log(this.listUser)
//       })
//     },
//     // get student id
//     getStudentId(id) {
//       axios
//         .get(this.URL + '/' + `${id}`)
//         .then(response => {
//           this.id_user = response.data.id
//           console.log(this.id_user)
//         })
//         .catch(error => {
//           console.error(error)
//         })
//     },
//     // get score form input number
//     getScore(student) {
//       let scores = []
//       for (var subject in student) {
//         if (typeof student[subject] === 'number') {
//           scores.push(student[subject])
//         }
//       }
//       return scores
//     },
//     // submit score and subject to database
//     SubmitScoreSubject() {
//       // Map the subjects array to an array of objects with subject_name and subject_score properties
//       const subjectsData = this.subjects.map(value => ({
//         subject_name: value.subject_name,
//         subject_score: value.subject_score
//       }))
//       let subjectInput = ''
//       let scoreInput = 0
//       for (let value of subjectsData) {
//         scoreInput = value.subject_score
//         if (value.subject_name == 'K') {
//           subjectInput = 1
//         } else if (value.subject_name == 'M') {
//           subjectInput = 2
//         } else if (value.subject_name == 'E') {
//           subjectInput = 3
//         } else if (value.subject_name == 'H') {
//           subjectInput = 4
//         } else if (value.subject_name == 'B') {
//           subjectInput = 5
//         } else if (value.subject_name == 'GEO') {
//           subjectInput = 6
//         } else if (value.subject_name == 'ES') {
//           subjectInput = 7
//         } else if (value.subject_name == 'MC') {
//           subjectInput = 8
//         } else if (value.subject_name == 'CH') {
//           subjectInput = 9
//         } else if (value.subject_name == 'P') {
//           subjectInput = 10
//         } else if (value.subject_name == 'SP') {
//           subjectInput = 11
//         } else if (value.subject_name == 'ICT') {
//           subjectInput = 12
//         }
//       }
//       console.log(subjectInput)

//       // Create an object with user_id and subjects properties
//       const postData = {
//         score: scoreInput,
//         subject_id: subjectInput,
//         month: this.month,
//         user_id: this.id_user
//       }
//       console.log(postData)

//       // Send a POST request to the API endpoint with the postData as the request body
//       http
//         .post('/scores', postData)
//         .then(response => {
//           response.data
//           console.log(postData)
//           swal.fire({
//             icon: 'success',
//             title: 'Send score successfully!',
//             text: 'you already send score with subject.',
//             timer: 2000
//           })
//         })
//         .catch(error => {
//           console.error(error)
//         })
//     },
//     getStudentInClass(classId) {
//       http
//         .get(`/get-students`)
//         .then(response => {
//           if (!this.selectedClass || this.selectedClass == 'noChoosen') {
//             this.listUser = response.data.data
//           } else {
//             this.listUser = response.data.data.filter(
//               teacher => parseInt(teacher.class_room_id) === parseInt(classId)
//             )
//           }
//         })
//         .catch(error => {
//           console.log(error)
//         })
//     },
//     async getClassrooms() {
//       const cachedResponse = cache.get('teacher_classroom')

//       if (cachedResponse) {
//         this.classrooms = cachedResponse
//         return
//       }

//       try {
//         const response = await http.get('/user')
//         this.classrooms = response.data.data.class_teacher
//         cache.set('teacher_classroom', this.classrooms)
//       } catch (error) {
//         console.error(error)
//       }
//       if (this.classrooms.length === 0) {
//         this.snackbar = true
//       }
//     }
//   },
//   computed: {
//     // compute total of score that we have been inputed
//     getTotalScore() {
//       return function (student) {
//         let total = 0
//         let subject_name = ''
//         let subjectScore = ''
//         const subjects = ['K', 'M', 'E', 'H', 'B', 'GEO', 'ES', 'MC', 'CH', 'P', 'SP', 'ICT']
//         for (var i = 0; i < subjects.length; i++) {
//           const subject = subjects[i]
//           if (typeof student[subject] === 'number' && !isNaN(student[subject])) {
//             subject_name = subjects[i]
//             subjectScore = student[subject]
//             total += student[subject]

//             // Check if the subject already exists in the array
//             const existingSubjectIndex = this.subjects.findIndex(
//               s => s.subject_name === subject_name
//             )
//             if (existingSubjectIndex !== -1) {
//               // Update the subject_score property of the existing object
//               this.subjects[existingSubjectIndex].subject_score = subjectScore
//             } else {
//               // Push a new object to the array
//               this.subjects.push({
//                 subject_name: subject_name,
//                 subject_score: subjectScore
//               })
//             }
//           }
//         }
//         return total
//       }
//     },
//     // get average score that we have been inputed
//     getAverageScore() {
//       return function (student) {
//         let total = this.getTotalScore(student)
//         return (total / 12).toFixed(2)
//       }
//     }
//   },
//   mounted() {
//     this.getStudentInClass()
//     this.getClassrooms()
//     return this.getStudent()
//   }
// }
</script>

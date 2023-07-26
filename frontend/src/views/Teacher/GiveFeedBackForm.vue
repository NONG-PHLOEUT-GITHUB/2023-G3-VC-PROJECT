<template>
  <div class="give-feedback-container">
    <h2>Give Feedback</h2>
    <form @submit.prevent="giveComment">
      <div class="form-group">
        <label for="student-name">Student</label>
        <div class="select-container">
          <select
            v-model="selectedStudent" 
            class="form-select"
            aria-label="Default select example"
          >
            <option v-for="student in listUser" :key="student.id" :value="student.id">
              {{ student.first_name }} {{ student.last_name }}
            </option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="feedback-text">Feedback</label>
        <textarea
          id="feedback-text"
          name="feedback-text"
          rows=""
          required
          v-model="comment"
        ></textarea>
      </div>
      <button type="submit">Submit</button>
    </form>
  </div>
</template>

<script>

import Swal from "sweetalert2";
import http from '@/htpp.common'
export default {
  data() {
    return {
      listUser: [],
      selectedStudent: null, 
      comment: ''
    };
  },
  methods: {
    getData() {
      http.get('/get-students').then((response) => {
        this.listUser = response.data;
      });
    },
    giveComment() {
      const commentData = {
        'body': this.comment,
        'user_id': this.selectedStudent, // Use only the selected student's ID in the POST request
      };
      console.log(commentData);
      http
        .post('/comments', commentData)
        .then((response) => {
          console.log(response);
        })
        Swal.fire({
          icon: "success",
          title: "Message sent successfully!",
          text: "Your Comment successfully to student",
          timer: 2000,
        })
      // Reset form fields after submission
      this.selectedStudent = null;
      this.comment = '';
    },
  },
  mounted() {
    this.getData();
  },
};
</script>
<style scoped>
.give-feedback-container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}

.give-feedback-container h2 {
  text-align: center;
  margin-bottom: 20px;
}

.give-feedback-container form {
  display: flex;
  flex-direction: column;
}

.give-feedback-container .form-group {
  margin-bottom: 20px;
}

.give-feedback-container textarea {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 100%;
}

.give-feedback-container select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  background-color: #fff;
}
.give-feedback-container select option:checked {
  background-color: #007bff;
  color: #fff;
}

.give-feedback-container select option {
  background-color: #fff;
  color: #000;
}

.give-feedback-container button[type="submit"] {
  padding: 10px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
}
.give-feedback-container button[type="submit"]:hover {
  background-color: #0069d9;
}
</style>
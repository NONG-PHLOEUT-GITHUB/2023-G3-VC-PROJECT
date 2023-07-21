<template>
  <div>
    <h3 class="mt-4 mb-4">Student attendance check list</h3>
    <div class="d-flex">
      <select class="form-select mb-3 w-25" aria-label="Default select example">
        <option value="">Grade 10 A</option>
        <option value="">Grade 10 A</option>
      </select>
      <div class="checkToday ms-4">
        <input
          type="checkbox"
          class="selectattendance mt-4 me-2 text-muted"
          @click="SelectAttendace()"
        />Attendance Today :
        {{ this.date }}
        <table>
          {{
            this.data
          }}
        </table>
      </div>
    </div>
    <table
      class="table align-middle mb-0 bg-white mt-4 rounded-3 shadow-lg p-3 mb-5 bg-body rounded"
    >
      <thead class="bg-light">
        <tr>
          <th>Name</th>
          <th>Title</th>
          <th>Status</th>
          <th>Reason</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <div class="d-flex align-items-center">
              <img
                src="https://mdbootstrap.com/img/new/avatars/8.jpg"
                alt=""
                style="width: 45px; height: 45px"
                class="rounded-circle"
              />
              <div class="ms-3">
                <p class="fw-bold mb-1">John Doe</p>
              </div>
            </div>
          </td>

          <td>Male</td>
          <td>
            <input type="checkbox" />
          </td>
          <td>
            <textarea
              class="form-control"
              name=""
              id=""
              cols="50"
              rows="2"
            ></textarea>
          </td>

          <td>
            <router-link :to="{ path: '/student_detail' }">
              <button
                type="button"
                class="btn btn-sm btn-neutral text-dark text-primary-hover bg-gray-300"
              >
                <i class="bi bi-person-circle text-warning"></i> View Profile
              </button>
            </router-link>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="card-footer border-0 d-flex w-100">
      <span class="text-muted text-sm">All Students in class</span>
      <button class="btn btn-pramary bg-primary">Save</button>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    date: null,
  }),
  methods: {
    SelectAttendace() {
      const today = new Date();
      const date =
        today.getFullYear() +
        "-" +
        (today.getMonth() + 1) +
        "-" +
        today.getDate();
      this.date = date;
      // console.log(this.date);
      // this.students.forEach((student) => {
      //   student.status = false;
      // });
    },
  },
};
</script>

<style scoped>
.table {
  border-radius: 10px;
  box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
}
.card-footer {
  padding: 0;
  display: flex;
  justify-content: space-between;
  /* background: #000; */
}
.card-footer .btn {
  width: 18%;
  margin-left: 20px;
}
</style>
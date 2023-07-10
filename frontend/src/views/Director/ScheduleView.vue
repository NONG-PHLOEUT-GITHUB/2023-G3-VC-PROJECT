<template>
  <div class="card shadow border-0 mb-7">
    <div class="card-header">
      <h3 class="mb-0 text-primary">WEEKLY SCHEDULE</h3>
    </div>
    <div class="card-header">
      <select
        class="form-select mb-3"
        aria-label="Default select example"
        style="width: 30%"
      >
        <option selected disabled>Select grade</option>
        <option value="10">Grade 10A</option>
        <option value="10">Grade 10B</option>
        <option value="10">Grade 10C</option>
        <option value="11">Grade 11A</option>
        <option value="11">Grade 11B</option>
        <option value="11">Grade 11C</option>
        <option value="11">Grade 12A</option>
        <option value="12">Grade 12B</option>
      </select>
    </div>
    <div class="card-header">
      <h3 class="mb-0 p-0 text-primary">CLASS 12A</h3>
    </div>
    <div class="table-responsive" v-for="(shift, index) in timetable" :key="index">
        <div class="card-header">
          <h4 class="mb-0 p-0 text-primary text-uppercase">{{Object.keys(shift)[0]}} SHIFT</h4>
        </div>
        <table class="table table-hover table-nowrap table-striped">
            <thead class="bg-primary">
            <tr>
                <th scope="col" class="fs-6 text-light">Time/Days</th>
                <th scope="col" class="fs-6 text-light">Monday</th>
                <th scope="col" class="fs-6 text-light">Tuesday</th>
                <th scope="col" class="fs-6 text-light">Wednesday</th>
                <th scope="col" class="fs-6 text-light">Thursday</th>
                <th scope="col" class="fs-6 text-light">Friday</th>
                <th scope="col" class="fs-6 text-light">Saturday</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(timetable, value) in Object.values(shift)[0]" :key="value" class="border-2-dark">
                <td class="bg-gray-400">
                {{ timetable.time }}
                </td>
                <td>
                {{ timetable.monday }}
                </td>
                <td>
                {{ timetable.tuesday }}
                </td>
                <td>
                {{ timetable.wednesday }}
                </td>
                <td>
                {{ timetable.thursday }}
                </td>
                <td>
                {{ timetable.friday }}
                </td>
                <td>
                {{ timetable.saturday }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
        timetable: [

            {morning: [
              {
                time: "07:00AM-08:00AM",
                monday: "English",
                tuesday: "History",
                wednesday: "Geography",
                thursday: "Chemistry",
                friday: "Math",
                saturday: "Biology",
              },
              {
                time: "08:00AM-09:00AM",
                monday: "English",
                tuesday: "History",
                wednesday: "Geography",
                thursday: "Chemistry",
                friday: "Math",
                saturday: "Biology",
              },
              {
                time: "09:00AM-10:00AM",
                monday: "English",
                tuesday: "History",
                wednesday: "Geography",
                thursday: "Chemistry",
                friday: "Math",
                saturday: "Biology",
              },
              {
                time: "10:00AM-11:00AM",
                monday: "English",
                tuesday: "History",
                wednesday: "Geography",
                thursday: "Chemistry",
                friday: "Math",
                saturday: "Biology",
              },
            ]},
            {afternoon: [
              {
                time: "01:00PM-02:00PM",
                monday: "English",
                tuesday: "History",
                wednesday: "Geography",
                thursday: "Chemistry",
                friday: "Math",
                saturday: "Biology",
              },
              {
                time: "02:00AM-03:00PM",
                monday: "English",
                tuesday: "History",
                wednesday: "Geography",
                thursday: "Chemistry",
                friday: "Math",
                saturday: "Biology",
              },
              {
                time: "03:00AM-04:00AM",
                monday: "English",
                tuesday: "History",
                wednesday: "Geography",
                thursday: "Chemistry",
                friday: "Math",
                saturday: "Biology",
              },
              {
                time: "04:00AM-05:00AM",
                monday: "English",
                tuesday: "History",
                wednesday: "Geography",
                thursday: "Chemistry",
                friday: "Math",
                saturday: "Biology",
              },
            ]},
        ]
    };
  },
};
</script>

<template>
  <custom-title icon="mdi-human-male-board">
    <template #right>
      <v-btn
        icon="mdi-filter-multiple-outline"
        variant="tonal"
        class="me-2 bg-primary"
        @click="toggleFilter = !toggleFilter"
      ></v-btn>
      <v-btn
        variant="tonal"
        class="me-2 bg-deep-orange-accent-4"
        icon="mdi-file-pdf-box"
        @click="downloadPDF()"
      ></v-btn>
      <v-btn variant="tonal" class="me-2 bg-green-darken-1" icon="mdi-file-excel"></v-btn>
    </template>
  </custom-title>
  <teacher-filter v-show="toggleFilter" />
  <v-card>
    <v-data-table-server
      v-model:items-per-page="itemsPerPage"
      :headers="headers"
      :items="teachers"
      :items-length="teachers.length"
      :loading="loading"
      :search="search"
      item-value="name"
    >
      <template v-slot:item.profile="{ item }">
        <v-avatar size="large">
          <v-img :src="item.profile" alt="Avatar" cover> </v-img>
        </v-avatar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-btn
          :to="{ path: '/user/' + item.id + '/edit' }"
          variant="text"
          icon="mdi-pencil"
        ></v-btn>

        <v-btn @click="removeTeacher(item.id)" variant="text" icon="mdi-delete-forever" color="red">
        </v-btn>
      </template>
    </v-data-table-server>
  </v-card>
</template>

<script>
import jsPDF from 'jspdf'
import html2canvas from 'html2canvas'
import http from '@/api/api'
import TeacherFilter from '@/components/filters/TeacherFilter.vue'
import { useTeacherStore } from '@/stores/teacher'
import { mapActions, mapState } from 'pinia'
export default {
  components: {
    TeacherFilter
  },
  created() {
    this.getTeachers()
  },
  data() {
    return {
      isDownloading: false,
      toggleFilter: false,
      isDetail: false,
      pdfUrl: null,
      selectedClass: null,
      classrooms: [],
      itemsPerPage: 10,
      headers: [
        { title: 'ID', key: 'id' },
        { title: 'Profile', key: 'profile' },
        { title: 'First Name', key: 'first_name' },
        { title: 'Last Name', key: 'last_name' },
        { title: 'Gender', key: 'gender' },
        { title: 'Age', key: 'age' },
        { title: 'Phone Number', key: 'phone_number' },
        { title: 'Address', key: 'address' },
        { title: 'Email', key: 'email' },
        { title: '', key: 'actions' ,width: '10%'}
      ]
    }
  },
  computed: {
    ...mapState(useTeacherStore, ['teachers'])

  },
  methods: {
    ...mapActions(useTeacherStore,['getTeachers','deleteTeacher']),
    removeTeacher(id){
      this.deleteTeacher(id);
      this.getTeachers()
    },
    downloadPDF() {
      this.isDetail = true
      http
        .get('users/get/teachers')
        .then(response => {
          this.teachers = response.data.data
          const element = document.getElementById('my-table')
          html2canvas(element).then(canvas => {
            const imgData = canvas.toDataURL('image/png')
            const pdf = new jsPDF()
            const imgProps = pdf.getImageProperties(imgData)
            const pdfWidth = pdf.internal.pageSize.getWidth()
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width
            pdf.addImage(imgData, 'JPEG', 0, 0, pdfWidth, pdfHeight)
            pdf.save('download.pdf')
            this.isDetail = false
            this.getTeachers()
          })
        })
        .catch(error => {
          console.error(error)
        })
    },

    getClassrooms() {
      http
        .get('/classrooms')
        .then(response => {
          this.classrooms = response.data.data
        })
        .catch(error => {
          console.log('Error fetching classrooms:', error)
        })
    },
    
  },
  mounted() {
    this.getClassrooms()
  }
}
</script>

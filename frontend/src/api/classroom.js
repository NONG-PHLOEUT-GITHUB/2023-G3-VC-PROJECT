import http from './api'

export function createNewClassroom(data) {
  return http.post(`/classrooms`,data)
}
export function updateClassroom(data,id) {
  return http.put(`classrooms/${id}/update`,data)
}
export function deleteClassroom(id) {
  return http.delete(`/classrooms/${id}/delete`)
}
export function fetchClassrooms(filterCriteria) {
  return http.get(`/classrooms`,{ params: filterCriteria })
}
export function fetchClassroomById() {
  return http.get(`/classrooms/${id}`)
}
//get the classroom to check attendance in class 
export function fetchStudentsInClassroomById(classroom_id) {
  return http.get(`classrooms/students/${classroom_id}/student-in-classroom`)
}
export function fetchTotalOfClassroom() {
  return http.get(`classrooms/total/get-classroom-total`)
}
export function fetchClassroomDetails(classroom_id) {
  return http.get(`classrooms/${classroom_id}/details`)
}


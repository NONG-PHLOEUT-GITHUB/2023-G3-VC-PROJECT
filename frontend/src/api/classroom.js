import http from './api'

/**
 * @param {string} class_name
 * @param {string}
 * @returns
 **/

export function createNewClassroom(data) {
  return http.post(`/classrooms`,data)
}
export function updateClassroom() {
  return http.put(`${id}/update`)
}
export function deleteClassroom(id) {
  return http.delete(`/classrooms/${id}/delete`)
}
export function fetchClassrooms() {
  return http.get(`/classrooms`)
}
export function fetchClassroomById() {
  return http.get(`/classrooms/${id}`)
}
export function fetchStudentsInClassroomById(classroom_id) {
  return http.get(`classrooms/students/${classroom_id}/classroom`)
}
export function fetchTotalOfClassroom() {
  return http.get(`classrooms/total/get-classroom-total`)
}
export function fetchClassroomDetails(classroom_id) {
  return http.get(`classrooms/${classroom_id}/details`)
}


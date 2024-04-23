import http from './api'

/**
 * @param {string} class_name
 * @param {string}
 * @returns
 **/

export function createNewClassroom() {
  return http.post(`/classrooms`)
}
export function updateClassroom() {
  return http.put(`${id}/update`)
}
export function deleteClassroom() {
  return http.delete(`/classrooms/${id}/delete`)
}
export function fetchClassrooms() {
  return http.get(`/classrooms`)
}
export function fetchClassroomById() {
  return http.get(`/classrooms/${id}`)
}
export function fetchStudentsInClassroomById() {
  return http.get(`/students/${classroom_id}/classroom`)
}
export function fetchTotalOfClassroom() {
  return http.get(`/total/classroom`)
}

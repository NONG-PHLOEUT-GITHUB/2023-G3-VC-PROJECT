import http from './api'

/**
 * @param {string} 
 * @param {string}
 * @returns
 **/

export function fetchStudents() {
  return http.get(`users/get/students`)
}
export function fetchStudentDetails(id) {
  return http.get(`users/${id}/details`)
}
export function createUsers(data) {
  return http.post(`users/create-user`,data)
}
export function deleteStudent() {
  return http.put(`student/${id}/delete`)
}
export function updateUser() {
  return http.put(`users/${id}/update`)
}
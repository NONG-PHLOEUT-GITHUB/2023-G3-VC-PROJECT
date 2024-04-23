import http from './api'

/**
 * @param {string} 
 * @param {string}
 * @returns
 **/

export function fetchStudents() {
  return http.post(`/students`)
}
export function createUsers() {
  return http.put(`users/create`)
}
export function deleteStudent() {
  return http.put(`student/${id}/delete`)
}
export function updateUsers() {
  return http.put(`${id}/update`)
}
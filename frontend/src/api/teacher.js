import http from './api'

/**
 * @param {string} 
 * @param {string}
 * @returns
 **/

export function fetchTeachers() {
  return http.get(`/users/get/teachers`)
}
// export function createUsers() {
//   return http.put(`users/create`)
// }
export function deleteTeacherById(id) {
  return http.delete(`users/teacher/${id}/delete-teacher`)
}
// export function updateUsers() {
//   return http.put(`${id}/update`)
// }
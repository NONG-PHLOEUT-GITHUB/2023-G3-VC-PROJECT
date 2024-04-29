import http from './api'

// Authentication
/**
 * comments
 * @param {string} email
 * @param {string} password
 * @returns
 */

export function createGuardian() {
  return http.post('/guardians')
}
export function fetchGuardian() {
  return http.get('/guardians')
}
export function fetchChatIDGuardian() {
  return http.get(`/guardians/${id}/chat-id`)
}
export function fetchGuardianDetails(id) {
  return http.get(`/guardians/${id}/details`)
}
/**
 @param string $id
 **/
 export function deleteGuardian(id) {
  return http.delete(`/guardians/${id}/delete`)
}
export function updateGuardian() {
  return http.put(`/guardians/${id}/update`)
}
export function getCharIdGuardianOfStudent(user_id) {
  return http.get(`/users/chat_id/${user_id}`)
}

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
export function fetchGuardianDetails() {
  return http.get(`/guardians/${id}/details`)
}
export function deleteGuardian() {
  return http.get(`/guardians/${id}/delete`)
}
export function updateGuardian() {
  return http.get(`/guardians/${id}/update`)
}

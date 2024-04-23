import http from './api'

// Authentication
/**
 * comments
 * @param {string} email
 * @param {string} password
 * @returns
 */

export function createComment() {
  return http.post('/comments')
}
export function commentUser() {
  return http.post('/comments')
}
export function updateComment() {
  return http.put(`/comments/${id}/update`)
}
export function deleteComment() {
  return http.put(`/comments/${id}/delete`)
}
export function deleteComment() {
  return http.get('/comments')
}
export function fetchcommentOfStudent() {
  return http.put(`/student/${user_id}/${teacher_id}`)
}
import http from './api'

// Authentication
/**
 * comments
 * @param {string} email
 * @param {string} password
 * @returns
 */

export function createComment(data) {
  // console.log(data);
  return http.post('/comments',data)
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
// export function deleteComment() {
//   return http.get('/comments')
// }
export function fetchcommentOfStudent() {
  return http.get(`/student/${user_id}/${teacher_id}`)
}
import http from './api'

export function createComment(data) {
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
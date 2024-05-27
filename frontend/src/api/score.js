import http from './api'

export function fetchStudentScore() {
  return http.get('/attendances')
}

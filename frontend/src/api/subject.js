import http from './api'

export function fetchSubjects() {
  return http.get(`/subjects`)
}

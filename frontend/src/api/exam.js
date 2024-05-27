import http from './api'

export function createExam(data) {
  return http.post('/exams',data)
}
export function fetchExams() {
  return http.get('/exams',)
}
export function deleteExamAPI(id) {
  return http.delete(`/exams/${id}/delete`,)
}

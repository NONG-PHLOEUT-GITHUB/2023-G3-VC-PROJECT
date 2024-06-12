import http from './api'

export function createExam(data) {
	return http.post('/exams', data)
}
export function fetchExams(filterCriteria) {
	return http.get('/exams',{ params: filterCriteria })
}
export function deleteExamAPI(id) {
	return http.delete(`/exams/${id}/delete`)
}

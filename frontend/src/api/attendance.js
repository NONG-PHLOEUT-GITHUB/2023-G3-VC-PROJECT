import http from './api'

export function fetchAttendances() {
	return http.get('/attendances')
}
export function fetchAttendanceOfStudents() {
	return http.get('/get-attendance/students')
}
export function fetchStudentMostAbsence() {
	return http.get('/get-most-absence/students')
}
export function fetchStudentAttendance() {
	return http.get(`/get-attendance/${id}/student`)
}
export function fetchStudentAttendanceDetails(studentId) {
	return http.get(`attendances/student/${studentId}/attendance-details`)
}
export function createAttendance(data) {
	return http.post(`attendances/student/check-attendance`, data)
}

import http from './api'

// Authentication
/**
 * login
 * @param {string} email
 * @param {string} password
 * @returns
 */

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
export function fetchStudentMostAbsence() {
  return http.get(`/get-student-attendance/${id}/details`)
}

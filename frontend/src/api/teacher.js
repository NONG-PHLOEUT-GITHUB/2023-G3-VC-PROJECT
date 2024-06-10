import http from './api'

export function fetchTeachers() {
	return http.get(`/users/get/teachers`)
}
export function fetchCoordinators() {
	return http.get(`/users/teacher/coordinator`)
}

/**
 * @param {number} id
 **/
export function deleteTeacherById(id) {
	return http.delete(`users/teacher/${id}/delete-teacher`)
}

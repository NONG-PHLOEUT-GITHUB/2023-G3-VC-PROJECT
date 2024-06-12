import http from './api'

export function fetchTeachers(filterCriteria) {
	return http.get(`/users/get/teachers`,{ params: filterCriteria })
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

import http from './api'

// Authentication
/**
 * comments
 * @param {string} email
 * @param {string} password
 * @returns
 */

export function createGuardian(data) {
  return http.post('/guardians/create-guardian',data)
}
export function fetchGuardian() {
  return http.get('/guardians')
}
export function fetchChatIDGuardian() {
  return http.get(`/guardians/${id}/chat-id`)
}
export function fetchGuardianDetails(id) {
  return http.get(`/guardians/${id}/details`)
}
/**
 @param string $id
 **/
 export function deleteGuardian(id) {
  return http.delete(`/guardians/${id}/delete`)
}

export function deleteMultipleGuardians(ids) {
  const arrayIds = ids.map(id => {
    return id;
  });
  return http.delete(`guardians/delete-multiple`,{ data: { ids: arrayIds } })
}

export function updateGuardian(data) {
  return http.put(`/guardians/${data.id}/update`,data)
}
export function getCharIdGuardianOfStudent(user_id) {
  return http.get(`/users/chat_id/${user_id}`)
}

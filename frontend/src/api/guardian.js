import http from './api'

export function createGuardian(data) {
  return http.post('/guardians/create-guardian', data)
}
export function fetchGuardian(filterCriteria) {
  return http.get('/guardians', { params: filterCriteria })
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
    return id
  })
  return http.delete(`guardians/delete-multiple`, { data: { ids: arrayIds } })
}

export function updateGuardian(data) {
  const formData = new FormData()
  // Append _method to spoof the HTTP method to PUT
  formData.append('_method', 'PUT')
  Object.entries(data).forEach(([key, value]) => {
    formData.append(key, value)
  })
  return http.put(`/guardians/${data.id}/update`, formData)
}
export function getCharIdGuardianOfStudent(user_id) {
  return http.get(`/users/chat_id/${user_id}`)
}

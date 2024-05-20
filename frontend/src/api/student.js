import http from './api'

/**
 * @param {string}
 * @param {string}
 * @returns
 **/

export function fetchStudents() {
  return http.get(`users/get/students`)
}
export function fetchStudentDetails(id) {
  return http.get(`users/${id}/details`)
}
export function createUsers(data) {
  const formData = new FormData()
  // Append each key-value pair to the FormData object
  Object.entries(data).forEach(([key, value]) => {
    formData.append(key, value)
    
  })

  return http.post('users/create-user', formData, {
    headers: {
      'Content-Type': 'multipart/form-data' // Set content type to multipart/form-data
    }
  })
}
export function deleteStudent(id) {
  return http.delete(`users/student/${id}/delete`)
}

export function updateUser(data,id) {  
  // const formData = new FormData()
  // // Append each key-value pair to the FormData object
  // Object.entries(data).forEach(([key, value]) => {
  //   formData.append(key, value)
  //   console.log(key,value);
  // })

  const formData = new FormData();
  formData.append('email', data.email);
  formData.append('phone_number', data.phone_number);
  formData.append('address', data.address);
  formData.append('profile', data.profile);

  // return http.put(`users/${id}/update`,formData, {
  return http.put(`users/${id}/update`, formData, {
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    }
  });
}

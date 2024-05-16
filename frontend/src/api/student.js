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

export function updateUser(data) {

  // const newData = {
  //   first_name: data.first_name,
  //   last_name: data.last_name,
  //   role: data.role,
  //   profile: data.profile,
  //   phone_number: data.phone_number,
  //   email: data.email,
  //   address: data.address,
  //   gender: data.gender,
  //   date_of_birth: data.date_of_birth,
  // };

  // const formData = new FormData()
  // // Append each key-value pair to the FormData object
  // Object.entries(data).forEach(([key, value]) => {
  //   formData.append(key, value)
  // })
  const jsonData = JSON.stringify({
    first_name: data.first_name,
    last_name: data.last_name,
    role: data.role,
    profile: data.profile,
    phone_number: data.phone_number,
    email: data.email,
    address: data.address,
    gender: data.gender,
    date_of_birth: data.date_of_birth,
  });
  return http.put(`users/${data.id}/update`, jsonData, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  })
}

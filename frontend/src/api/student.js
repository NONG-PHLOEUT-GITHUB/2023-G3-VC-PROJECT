import { da } from 'vuetify/lib/locale/index.mjs'
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

export function deleteMultipleUsers(ids) {
  const arrayIds = ids.map(id => {
    return id;
  });
  return http.delete(`users/delete-multiple`,{ data: { ids: arrayIds } })
}

export function updateUser(data,id) {  
  // console.log('data',data,'id',id);
  // const formData = new FormData()
  // // Append each key-value pair to the FormData object
  // Object.entries(data).forEach(([key, value]) => {
  //   formData.append(key, value)
  // })
  // const jsonData = JSON.stringify(data);

  return http.put(`users/${id}/update`, data, {
    headers: {
      'Content-Type': 'multipart/form-data' 
    }
  });
}

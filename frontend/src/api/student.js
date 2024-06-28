import http from './api'

export function fetchStudents(filterCriteria) {
  return http.get(`users/get/students`,{ params: filterCriteria })
}
export function fetchStudentDetails(id) {
  return http.get(`users/${id}/details`)
}

export function showStudent(id) {
  return http.get(`users/${id}/show`)
}

export function createUsers(data) {
  const formData = new FormData()
  // Append each key-value pair to the FormData object
  Object.entries(data).forEach(([key, value]) => {
    if (value !== null) {
      formData.append(key, value);
    } else {
      // Handle null values as needed
      formData.append(key, ''); // Or some other placeholder value
    }
    
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
  const formData = new FormData()
  // Append _method to spoof the HTTP method to PUT
  formData.append('_method', 'PUT');
  Object.entries(data).forEach(([key, value]) => {
    if (value !== null) {
      formData.append(key, value);
    } else {
      // Handle null values as needed
      formData.append(key, ''); // Or some other placeholder value
    }
  })
  return http.post(`users/${id}/update`, formData, {
    headers: {
      'Content-Type': 'multipart/form-data' 
    }
  });
}

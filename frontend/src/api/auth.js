import http from './api'

// Authentication
/**
 * login
 * @param {string} email
 * @param {string} password
 * @returns
 */

export function userLogin(email, password) {
  const user = {
    email,
    password
  }
  return http.post('/v1/auth/login', user)
}
export function fetchUserLoged(filterCriteria) {
    return http.get('v1/auth/user',{ params: filterCriteria })
}

export function forgotPassword(email) {
  console.log(email);
  const data = {
    email
  }
  return http.post('auth/forgot-password', data)
}

export function resetNewPassword(data) {
  return http.post(`auth/reset-password/${data.token}`, data)
}

export function changeNewPassword(data) {
  return http.post(`auth/password/change`, data)
}

export function logout() {
  return http.post(`v1/auth/logout`)
}
export function updateProfile(data) {
  console.log(data);
  const formData = new FormData()
  // Append each key-value pair to the FormData object
  Object.entries(data).forEach(([key, value]) => {
    formData.append(key, value)
    
  })
  return http.put(`users/profile/update/${data.id}`,formData ,{
    headers: {
      'Content-Type': 'multipart/form-data' // Set content type to multipart/form-data
    }
  })
}

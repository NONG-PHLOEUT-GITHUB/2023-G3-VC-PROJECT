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
  return http.post('/v2/auth/login', user)
}
export function fetchUserLoged() {
  return http.get('/user')
}
// export function fetchUserLoged() {
//   return http.get('/v2/auth/user')
// }

export function forgotPassword(email) {
  const user = {
    email
  }
  return http.post('/forgot-password', user)
}

export function resetNewPassword(token, password, password_confirmation) {
  const user = {
    password,
    password_confirmation
  }
  return http.post(`/reset-new-password/${token}`, user)
}


export function changeNewPassword(current_password, new_password) {
  const user = {
    current_password,
    new_password
  }
  return http.post(`/change-password`, user)
}

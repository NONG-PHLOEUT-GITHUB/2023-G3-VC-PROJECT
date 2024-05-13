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
export function fetchUserLoged() {
  return http.get('v1/auth/user')
}

export function forgotPassword(email) {
  console.log(email);
  const data = {
    email
  }
  return http.post('auth/forgot-password', data)
}

export function resetNewPassword(data) {
  // const data = {
  //   password,
  //   password_confirmation
  // }
  return http.post(`auth/reset-password/${data.token}`, data)
}

export function changeNewPassword(data) {
  return http.post(`auth/password/change`, data)
}

export function logout() {
  return http.post(`v1/auth/logout`)
}

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
  return http.get('/user')
}

export function forgotPassword(email) {
  const data = {
    email
  }
  return http.post('auth/forgot-password', email)
}

export function resetNewPassword(token, password, password_confirmation) {
  const data = {
    password,
    password_confirmation
  }
  return http.post(`/reset-password/${token}`, data)
}

export function changeNewPassword(current_password, new_password) {
  const data = {
    current_password,
    new_password
  }
  return http.post(`/change-password`, data)
}

export function logout() {
  return http.post(`v1/auth/logout`)
}

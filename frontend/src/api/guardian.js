import http from './api'

// Authentication
/**
 * comments
 * @param {string} email
 * @param {string} password
 * @returns
 */

export function createGuardian() {
  return http.post('/Guardians')
}
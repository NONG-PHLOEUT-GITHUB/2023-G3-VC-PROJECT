import http from './api'

/**
 * @param {string} 
 * @param {string}
 * @returns
 **/

export function fetchSubjects() {
  return http.get(`/subjects`)
}

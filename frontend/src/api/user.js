import http from './api'

export function fetchUserProfile(){
    return http.get('/users/profile')
}
import http from './api'

export function fetchCalendrier(){
    return http.get('/calendrier/calendriers');
}

export function checkPeriodIsValid(period){
    return http.post('/calendrier/checkPeriod', {period: period});
}

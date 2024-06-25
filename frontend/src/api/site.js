import http from './api'

export function fetchSitesUser() {
  return http.get('/sites')
}

export function getClientSites(siteCode) {
  return http.get('/sites/clients', {
    params: { siteCode: siteCode }
  })
}

export function getClientOptions(params) {
  return http.get('sites/clientOption', {
    params: {
      siteCode: params.siteCode,
      isBU: params.isBU,
      isResponsable: params.isResponsable,
      isService: params.isService
    }
  })
}

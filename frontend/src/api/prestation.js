import http from './api'

export function fetchVisualisation(data) {
  return http.get(
    `/prestation/service/${data.siteCode}/${data.selectedCalendrier.calendrier_cloture_date_debut.replace(/\//g, '-')}`
  )
}

export function fetchServiceLigne() {
  return http.get('/prestation/ligne')
}

export function getPrestationById(enteteId) {
  return http.get(`/prestation/presta/${enteteId}`)
}

export function setPrestation(data) {
  return http.post('/prestation/setPrestation', data)
}

export function setPrestationLignes(data) {
  return http.post('/prestation/setPrestationLignes', data)
}

export function fetchDeleteVisualisation(id) {
  return http.delete(`/prestation/service/${id}`)
}

export function fetchSetPrestation(data) {
  return http.post(`/prestation/setPrestation/`, data)
}

export function fetchExcelFile(data) {
  return http.post(`/prestation/upload`, data,{
    headers: {
      'Content-Type': 'multipart/form-data'
    },
  })
}

export function fetchStatistiques(data) {
  return http.get(`/prestation/statistiques`, data);
}

export function deletePrestationLigne(prestaLigneId) {
  return http.delete(`/prestaLigne/${prestaLigneId}`)
}

export function getProforma(siteCode, prestaDate) {
  return http.get(`/prestation/proforma/${siteCode}`, {
    params: { prestaDate }
  });
}
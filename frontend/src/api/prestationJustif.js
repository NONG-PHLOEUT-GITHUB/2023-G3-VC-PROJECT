import http from "./api";

export function getJustificatifByEnteteId(prestaEnteteId) {
  return http.get(`/prestaJustif/${prestaEnteteId}`);
}

export function deleteJustificatif(justifId) {
  return http.delete(`/prestaJustif/${justifId}`);
}

export function addJustificatif(params) {
  return http.post(`/prestaJustif/upload/${params.prestaEnteteId}`, params.formData, {
    headers: {
      "Content-Type": "multipart/form-data"
    }
  });
}

export function printJustificatif(justifId) {
  return http.get(`/prestaJustif/print/${justifId}`, {
    responseType: 'blob'
  });
}
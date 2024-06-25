import http from "./api";

export function getAllRubriqueCa() {
  return http.get("/rubriqueCA/rubCAList");
}
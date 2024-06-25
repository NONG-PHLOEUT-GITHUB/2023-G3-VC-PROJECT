import http from "./api";

export function getAllRubriquePrestation() {
  return http.get("/rubPrestation/rubPrestaList");
}
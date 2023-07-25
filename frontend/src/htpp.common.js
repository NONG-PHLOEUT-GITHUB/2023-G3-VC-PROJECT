import axios from "axios";
import Cookies from "js-cookie";

const token = Cookies.get('access_token');
// const token = localStorage.getItem('access_token');
console.log(token);
export default axios.create({
  baseURL: "http://127.0.0.1:8000/",
  headers: {
    "Access-Control-Allow-Origin": "*",
    "Content-type": "application/json",
    "Authorization": "Bearer " + token,
  }
});
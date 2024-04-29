import axios from "axios";

const api = axios.create({
  baseURL: process.env.VUE_APP_API_BASE_URL || "http://127.0.0.1:8000/api/",
  headers: {
    "Access-Control-Allow-Origin": "*",
    'Content-type': 'application/json',
  },
});

api.interceptors.request.use(async (config) => {
  try {
    const token = localStorage.getItem('access_token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config
  } catch (error) {
    return Promise.reject(error)
  }
})

api.interceptors.response.use(async (response) => {
  try {
    // console.log(response);
    return response
  } catch (error) {
    return Promise.reject(error)
  }
})

export default api;
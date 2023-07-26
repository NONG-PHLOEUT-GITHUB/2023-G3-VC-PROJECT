// import axios from "axios";
// import Cookies from "js-cookie";

// const token = Cookies.get('access_token');
// // const token = localStorage.getItem('access_token');
// console.log(token);
// export default axios.create({
//   baseURL: "http://127.0.0.1:8000/",
//   headers: {
//     "Access-Control-Allow-Origin": "*",
//     "Content-type": "application/json",
//     "Authorization": "Bearer " + token,
//   }
// });



import axios from "axios";
import Cookies from "js-cookie";

const api = axios.create({
  // baseURL: 'http://172.16.0.130:8000/api/',
  baseURL: "http://backend:8000/api/",
  headers: {
    "Access-Control-Allow-Origin": "*",
    "Content-type": "application/json",
  },
});

// Add a request interceptor to add the Authorization header with the token
api.interceptors.request.use(async (config) => {
  const token = await getAccessToken();
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// Function to refresh the token
const refreshToken = async () => {
  const refreshToken = Cookies.get('refresh_token');
  if (!refreshToken) {
    return null;
  }
  try {
    const response = await axios.post('/api/refresh-token', { refresh_token: refreshToken });
    const token = response.data.access_token;
    Cookies.set('access_token', token, { expires: 14 });
    return token;
  } catch (error) {
    console.error(error);
    return null;
  }
};

// Function to get the access token
const getAccessToken = async () => {
  const token = Cookies.get('access_token');
  if (token) {
    const decodedToken = JSON.parse(atob(token.split('.')[1]));
    const expirationTime = decodedToken.exp * 1000;
    const currentTime = new Date().getTime();
    const timeUntilExpiration = expirationTime - currentTime;
    if (timeUntilExpiration < 60 * 1000) { // Refresh the token if it will expire in less than 1 minute
      await refreshToken();
    }
    return Cookies.get('access_token');
  }
  return null;
};

export default api;
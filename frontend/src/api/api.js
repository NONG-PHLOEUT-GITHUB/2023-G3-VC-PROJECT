import { useLoadingStore } from '@/stores/loading'
import axios from 'axios'
// import { createPinia, getActivePinia, setActivePinia } from 'pinia'

const api = axios.create({
  baseURL: import.meta.env.VITE_APP_API_BASE_URL,
  headers: {
    'Content-type': 'application/json'
  }
})

// // // Check if Pinia is active and set it if not
// if (!getActivePinia()) {
//   setActivePinia(createPinia())
// }
// Get store instance
const loadingStore = useLoadingStore()

// Request interceptor to show loading spinner
api.interceptors.request.use(
  config => {
    loadingStore.setLoading(true)
    const token = localStorage.getItem('access_token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  error => {
    loadingStore.setLoading(false)
    return Promise.reject(error)
  }
)

// Response Interceptor
api.interceptors.response.use(
  response => {
    loadingStore.setLoading(false)
    return response.data
  },
  error => {
    loadingStore.setLoading(false)
    return Promise.reject(error)
  }
)

export default api

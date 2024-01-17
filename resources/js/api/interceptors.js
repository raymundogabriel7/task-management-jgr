import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
  },
});

axiosInstance.interceptors.request.use(config => {
  const token = localStorage.getItem('token'); 
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  } else {
    window.location.href = import.meta.env.VITE_APP_BASE_URL + 'login'
  }
 
  return config;
}, error => {
    console.log('sdfs')
    console.log(error)
  return Promise.reject(error);
});

export default axiosInstance;
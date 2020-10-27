import axios from 'axios';


const axiosInstance = axios.create({
    baseURL: '/api'
});

//each ajax API call will have its progress bar loader for better UX
axiosInstance.interceptors.request.use(config => {
    // eslint-disable-next-line
    NProgress.start();
    return config;
});

axiosInstance.interceptors.response.use(response => {
    // eslint-disable-next-line
    NProgress.done();
    return response;
},
error => {
    // eslint-disable-next-line
    NProgress.done();
    return Promise.reject(error)
});

export default axiosInstance;

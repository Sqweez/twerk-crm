import axios from 'axios';
const axiosClient = axios.create();
const token = localStorage.getItem('token');

axiosClient.interceptors.request.use((config) => {
    config.baseURL = '/api/';
    if (token) {
        config.headers = {
            Authorization: 'Bearer ' + token
        };
    }
    return config;
});

export default axiosClient;

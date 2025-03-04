import axios from 'axios';

const backendUrl = import.meta.env.VITE_BACKEND_URL;

const api = axios.create({
    baseURL: backendUrl,
    timeout: 5000,
    headers: {
        'Content-Type': 'application/json',
    },
});

export default api;

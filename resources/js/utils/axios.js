import axios from "axios";

import { useAuthStore } from "@/stores/useAuthStore";

const base = axios.create({
    baseURL: "/api/V1",
    headers: {
        "Content-Type": "application/json",
    },
});

if (localStorage.getItem("token")) {
    base.interceptors.request.use(
        (config) => {
            const authStore = useAuthStore();
            const token = localStorage.getItem("token") || authStore.token;
            if (token) {
                config.headers.Authorization = `bearer ${token}`;
            }
            return config;
        },
        (error) => {
            return Promise.reject(error);
        }
    );
}

export default base;

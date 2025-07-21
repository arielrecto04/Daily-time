import { defineStore } from "pinia";
import { axios } from "@/utils";
import { useRouter } from "vue-router";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        _user: localStorage.getItem("user") || null,
        _token: localStorage.getItem("token") || null,
        error: {},
        isLoading: false,
        credential: {
            email: "",
            password: "",
            rememberMe: false,
        },
        router: useRouter(),
    }),

    getters: {
        user: (state) => {
            if (typeof state._user === "string") {
                return JSON.parse(state._user);
            }
            return state._user;
        },
        token: (state) => state._token,
        isAuthenticated: (state) => !!state._token,
    },

    actions: {
        setUser(newUser) {
            this._user = newUser;
            localStorage.setItem("user", JSON.stringify(newUser));
        },

        setToken(newToken) {
            this._token = newToken;
            if (newToken) {
                localStorage.setItem("token", newToken);
            } else {
                localStorage.removeItem("token");
            }
        },
        async login() {
            this.isLoading = true;
            this.error = {};
            try {
                const response = await axios.post("/login", this.credential);

                this.setToken(response?.data?.token);
                this.setUser(response?.data?.user);

                this.router.push("/dashboard");
            } catch (error) {
                if (error.response?.status) {
                    this.error = error.response?.data;
                    return;
                }
                console.log(error, "error");
            } finally {
                this.isLoading = false;
            }
        },

        async logout() {
            this.isLoading = true;
            try {
                await axios.post("/logout");
            } catch (error) {
                console.log(error, "error");
            } finally {
                this.setUser(null);
                this.setToken(null);
                this.isLoading = false;
                this.router.push("/login");
            }
        },
        async getUser() {
            this.isLoading = true;
            try {
                const response = await axios.get("/user");
                this.setUser(response?.data);
            } catch (error) {
                console.log(error, "error");
                if (error.response?.status === 401) {
                    localStorage.removeItem("token");
                    localStorage.removeItem("user");
                    this.router.push("/login");
                }
            } finally {
                this.isLoading = false;
            }
        },
    },
});

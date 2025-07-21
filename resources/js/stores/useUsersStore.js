import { defineStore } from "pinia";
import axios from "@/utils/axios";

export const useUsersStore = defineStore("users", {
    state: () => ({
        _users: [],
        _isLoading: false,
        _error: {},
        _user: {},

        pagination: {
            current_page: 1,
            per_page: 10,
            total: 0,
            last_page: 1,
            from: 1,
            to: 10,
            previous_page_url: null,
            next_page_url: null,
        },
        _status: {
            active: "active",
            inactive: "inactive",
            suspended: "suspended",
            list() {
                return Object.keys(this).filter((key) => key !== "list");
            },
        },
    }),
    getters: {
        users: (state) => state._users,
        isLoading: (state) => state._isLoading,
        error: (state) => state._error,
        user: (state) => state._user,
        listStatus: (state) => state._status.list(),
        status: (state) => state._status,
    },
    actions: {
        setUsers(users) {
            this._users = users;
        },
        selectUser(user) {
            this._user = user;
        },
        async fetchUsers() {
            this._isLoading = true;
            this._error = {};
            try {
                const response = await axios.get("/users");
                this.setUsers(response.data.data);
                this.pagination = response.data.pagination;
            } catch (error) {
                if (error.response?.status) {
                    console.log(error.response?.data);
                    this._error = error.response?.data;
                }
            } finally {
                this._isLoading = false;
            }
        },

        async storeUser(user) {
            this._error = {};
            try {
                const response = await axios.post("/users", user);
                this._users.push(response.data);
                this.selectUser(response.data);
            } catch (error) {
                if (error.response?.data) {
                    console.log(error.response?.data.errors);
                    this._error = error.response?.data.errors;
                }
            }
        },
        async updateUser(user) {
            this._error = {};
            try {
                const response = await axios.put(`/users/${user.id}`, user);
                this.selectUser(response.data);
                this._users = this._users.map((user) =>
                    user.id === response.data.id ? response.data : user
                );
            } catch (error) {
                if (error.response?.data) {
                    console.log(error.response?.data.errors);
                    this._error = error.response?.data.errors;
                }
            }
        },
        async deleteUser() {
            this._error = {};
            try {
                const response = await axios.delete(`/users/${this._user.id}`);
                this._users = this._users.filter(
                    (user) => user.id !== this._user.id
                );
            } catch (error) {
                if (error.response?.data) {
                    console.log(error.response?.data.errors);
                    this._error = error.response?.data.errors;
                }
            }
        },
        async toggleStatus(status) {
            this._error = {};
            try {
                const response = await axios.put(
                    `/users/toggle-status/${this._user.id}`,
                    { status }
                );
                this._users = this._users.map((user) => {
                    return user.id === response.data.id ? response.data : user;
                });

                this.selectUser(response.data);
            } catch (error) {
                if (error.response?.data) {
                    console.log(error.response?.data.errors);
                    this._error = error.response?.data.errors;
                }
            }
        },

        async updateDepartment(department) {
            this._error = {};
            try {
                const response = await axios.put(`/users/update-department/${this._user.id}`, { department });
                this.selectUser(response.data);
                this._users = this._users.map((user) => {
                    return user.id === response.data.id ? response.data : user;
                });
            } catch (error) {
                if (error.response?.data) {
                    console.log(error.response?.data.errors);
                    this._error = error.response?.data.errors;
                }
            }
        },
    },
});

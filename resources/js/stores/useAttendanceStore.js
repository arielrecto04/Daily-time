import { defineStore } from "pinia";
import { axios } from "@/utils";
import moment from "moment";
import { useAuthStore } from "./useAuthStore";

const authStore = useAuthStore();

export const useAttendanceStore = defineStore("attendance", {
    state: () => ({
        _attendances: [],
        isLoading: false,
        error: {},
        _checkIn: {
            name: authStore.user?.name,
            date: moment().format("YYYY-MM-DD"),
            check_in: null,
            late_in_minutes: null,
            day_of_week: moment().format("dddd"),
            user_id: authStore.user.id,
        },
        // This pagination object will be populated by the API response
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
        _attendance: {
            name: null,
            date: null,
            check_in: null,
            check_out: null,
            late_in_minutes: null,
            overtime_in_minutes: null,
            day_of_week: null,
            duration_days: null,
            user_id: null,
        },
        _currentAttendance: null,
        _checkOut: {
            check_out: null,
            overtime_in_minutes: null,
            duration_days: null,
        },
    }),

    getters: {
        // Use a computed getter for attendances
        attendances: (state) => state._attendances,
        selectedAttendance: (state) => {
            return state._attendance;
        },
        getCurrentAttendance: (state) => {
            return state._currentAttendance;
        },
    },

    actions: {
        selectedByAttendance(attendance_id) {
            const attendance = this._attendances.find(
                (attendance) => attendance.id == attendance_id
            );
            this._attendance = attendance;
        },

        removeAttendance(id) {
            this._attendances = this._attendances.filter(
                (attendance) => attendance.id !== id
            );
        },

        /**
         * Fetches attendance records from the API for a specific page.
         * @param {number} page - The page number to fetch.
         * @param {number} perPage - The number of items per page.
         */
        async fetchAttendance(page = 1, perPage = 10) {
            this.isLoading = true;
            this.error = {};
            try {
                const response = await axios.get(
                    `/attendances?page=${page}&per_page=${perPage}`
                );
                // Update state with the data from the API
                this._attendances = response.data.data;

                // Update the pagination state object with the response from the API
                this.pagination = {
                    current_page: response.data.current_page,
                    per_page: response.data.per_page,
                    total: response.data.total,
                    last_page: response.data.last_page,
                    from: response.data.from,
                    to: response.data.to,
                    previous_page_url: response.data.prev_page_url,
                    next_page_url: response.data.next_page_url,
                };
            } catch (error) {
                console.log(error, "error");
                if (error.response?.status) {
                    this.error = error.response?.data;
                }
            } finally {
                this.isLoading = false;
            }
        },

        async checkIn() {
            this.error = {};
            try {
                const response = await axios.post(
                    "/attendances/check-in",
                    (this._checkIn = {
                        ...this._checkIn,
                        check_in: moment(new Date()).format("HH:mm:ss"),
                    })
                );

                this._currentAttendance = response.data;
                this._attendances.push(response.data);
            } catch (error) {
                if (error.response?.status) {
                    this.error = error.response?.data;
                }
            } finally {
                // handle final state
            }
        },

        async checkOut() {
            this.error = {};
            try {
                const response = await axios.put(
                    `/attendances/check-out/${this._currentAttendance.id}`,
                    (this._checkOut = {
                        ...this._checkOut,
                        check_out: moment(new Date()).format("HH:mm:ss"),
                    })
                );

                this._attendances = this._attendances.map((attendance) => {
                    if (attendance.id == this._currentAttendance.id) {
                        console.log(response.data);
                        return response.data;
                    }
                    return attendance;
                });
                this._currentAttendance = null;
            } catch (error) {
                if (error.response?.status) {
                    this.error = error.response?.data;
                }
            } finally {
            }
        },

        async deleteAttendance(id) {
            this.error = {};
            try {
                const response = await axios.delete(`/attendances/${id}`);
                this.removeAttendance(id);
            } catch (error) {
                if (error.response?.status) {
                    this.error = error.response?.data;
                }
            } finally {
                // handle final state
            }
        },
        async currentAttendance() {
            try {
                const response = await axios.get(
                    `/attendances/current-attendance/${authStore.user.id}`
                );
                this._currentAttendance = response.data;
            } catch (error) {
                if (error.response?.status) {
                    this.error = error.response?.data;
                }
            } finally {
                // handle final state
            }
        },
    },
});

import { defineStore } from "pinia";
import { axios } from "@/utils";

export const useLeaveTypeStore = defineStore("leaveType", {
    state: () => ({
        _leaveTypes: [],
        _leaveType: null,
        _leaveTypePagination: {
            total: 0,
            per_page: 0,
            current_page: 0,
            last_page: 0,
            from: 0,
            to: 0,
        },
    }),
    getters: {
        leaveTypes: (state) => state._leaveTypes,
        leaveType: (state) => state._leaveType,
        pagination: (state) => state._leaveTypePagination,
    },
    actions: {
        selectLeaveType(leaveType) {
            this._leaveType = leaveType;
        },

        async fetchLeaveTypes() {
            try {
                const response = await axios.get("/leave-types");
                this._leaveTypes = response.data.data;
                this._leaveTypePagination = {
                    total: response.data.total,
                    per_page: response.data.per_page,
                    current_page: response.data.current_page,
                    last_page: response.data.last_page,
                    from: response.data.from,
                    to: response.data.to,
                };
            } catch (error) {
                console.error("Error fetching leave types:", error);
            }
        },
        async fetchLeaveTypeById() {
            try {
                const response = await axios.get(
                    `/leave-types/${this.leaveType.id}`
                );
                this._leaveType = response.data;
            } catch (error) {
                console.error("Error fetching leave type:", error);
            }
        },
        async storeLeaveType(data) {
            try {
                const response = await axios.post("/leave-types", data);
                this._leaveType = response.data;
                this._leaveTypes.push(response.data);
            } catch (error) {
                console.error("Error storing leave type:", error);
            }
        },
        async updateLeaveType(data) {
            try {
                const response = await axios.put(
                    `/leave-types/${this.leaveType.id}`,
                    data
                );
                this._leaveType = response.data;
                this._leaveTypes = this._leaveTypes.map((leaveType) => {
                    if (leaveType.id === this.leaveType.id) {
                        return response.data;
                    }
                    return leaveType;
                });
            } catch (error) {
                console.error("Error updating leave type:", error);
            }
        },
        async deleteLeaveType() {
            try {
                const response = await axios.delete(
                    `/leave-types/${this.leaveType.id}`
                );

                this._leaveTypes = this._leaveTypes.filter((leaveType) => {
                    return leaveType.id !== this.leaveType.id;
                });

                this._leaveType = null;
            } catch (error) {
                console.error("Error deleting leave type:", error);
            }
        },
        async updateStatus() {
            try {
                const response = await axios.put(
                    `/leave-types/update-status/${this.leaveType.id}`
                );
                this._leaveType = response.data;
                this._leaveTypes = this._leaveTypes.map((leaveType) => {
                    if (leaveType.id === this.leaveType.id) {
                        return response.data;
                    }
                    return leaveType;
                });
            } catch (error) {
                console.error("Error updating leave type:", error);
            }
        },
        async updateCredited() {
            try {
                const response = await axios.put(
                    `/leave-types/update-credited/${this.leaveType.id}`
                );
                this._leaveType = response.data;
                this._leaveTypes = this._leaveTypes.map((leaveType) => {
                    if (leaveType.id === this.leaveType.id) {
                        return response.data;
                    }
                    return leaveType;
                });
            } catch (error) {
                console.error("Error updating leave type:", error);
            }
        },
    },
});

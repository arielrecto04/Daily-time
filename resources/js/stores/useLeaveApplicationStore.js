import { defineStore } from 'pinia';
import axios from '@/utils/axios';


export const useLeaveApplicationStore = defineStore('leaveApplication', {
    state: () => ({
        _leaveApplications: [],
        _isLoading: false,
        _leaveApplication: null,
        _error: {},
        _pagination: {
            total: 0,
            per_page: 0,
            current_page: 0,
            last_page: 0,
            from: 0,
            to: 0,
        },
    }),

    getters: {
        leaveApplication: (state) => state._leaveApplication,
        leaveApplications: (state) => state._leaveApplications,
        isLoading: (state) => state._isLoading,
        error: (state) => state._error,
        pagination: (state) => state._pagination,
    },
    actions: {
        selectLeaveApplication(application) {
            this._leaveApplication = application;
        },

        async fetchLeaveApplications() {
            this._isLoading = true;
            try {
                const response = await axios.get('/leave-applications');
                this._leaveApplications = response.data.data;
                this._pagination = response.data.pagination = {
                    total: response.data.pagination.total,
                    per_page: response.data.pagination.per_page,
                    current_page: response.data.pagination.current_page,
                    last_page: response.data.pagination.last_page,
                    from: response.data.pagination.from,
                    to: response.data.pagination.to,
                };
            } catch (error) {
                console.error('Error fetching leave applications:', error);
            } finally {
                this._isLoading = false;
            }
        },

        async createLeaveApplication(application) {
            this._isLoading = true;
            try {
                const response = await axios.post('/leave-applications', application);
                this._leaveApplications.push(response.data);
            } catch (error) {
                console.error('Error adding leave application:', error);
                console.log(error)
                this._error = error.response.data.errors;
            } finally {
                this._isLoading = false;
            }
        },


        async updateLeaveApplication (id){
            this._isLoading = true;
            try {
                const response = await axios.put(`/leave-applications/${id}`, this._leaveApplication)
                this._leaveApplication = response.data;
            } catch (error){
                this._error = error.response.data.errors;
            } finally {
                this._isLoading = false;
            }
        },


        async removeLeaveApplication() {
            this._isLoading = true;
            try {
                await axios.delete(`/leave-applications/${this._leaveApplication.id}`);
                this._leaveApplications = this._leaveApplications.filter(app => app.id !== this._leaveApplication.id);
                this._leaveApplication = null;
            } catch (error) {
                console.error('Error removing leave application:', error);
            } finally {
                this._isLoading = false;
            }
        },
        async fetchLeaveApplication(id) {
            this._isLoading = true;
            try {
                const response = await axios.get(`/leave-applications/${id}`);
                this._leaveApplication = response.data;
            } catch (error) {
                console.error('Error fetching leave application:', error);
            } finally {
                this._isLoading = false;
            }
        }
    },
});


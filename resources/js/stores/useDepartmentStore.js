import { defineStore } from 'pinia';
import { axios} from '@/utils';

export const useDepartmentStore = defineStore('department', {
    state: () => ({
        _departments: [],
        _department: null,
        _isLoading: false,
        _error: null,
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
        departments: (state) => state._departments,
        department: (state) => state._department,
        isLoading: (state) => state._isLoading,
        error: (state) => state._error,
        pagination: (state) => state._pagination,
    },
    actions: {

        setSelectedDepartment(department) {
            this._department = department;
        },
        async fetchDepartments() {
            try {
                this._isLoading = true;
                const response = await axios.get('/departments');
                this._departments = response.data.data;
                this._pagination = {
                    total: response.data.total,
                    per_page: response.data.per_page,
                    current_page: response.data.current_page,
                    last_page: response.data.last_page,
                    from: response.data.from,
                    to: response.data.to,
                };
            } catch (error) {
                this._error = error;
            } finally {
                this._isLoading = false;
            }
        },
        async storeDepartment(department) {
            try {
                const response = await axios.post('/departments', department);
                this._departments.push(response.data);
            } catch (error) {
                this._error = error;
            } finally {
            }
        },
        async updateDepartment(department) {
            try {
                const response = await axios.put(`/departments/${department.id}`, department);
                this._department = response.data;
            } catch (error) {
                this._error = error;
            } finally {
            }
        },
        async deleteDepartment() {
            try {
                await axios.delete(`/departments/${this._department.id}`);
                this._departments = this._departments.filter((department) => department.id !== this._department.id);
            } catch (error) {
                this._error = error;
            } finally {
            }
        },
    },
});

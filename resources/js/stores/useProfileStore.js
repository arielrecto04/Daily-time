import { defineStore } from 'pinia';
import axios from '@/utils/axios';

export const useProfileStore = defineStore('profile', {
    state: () => ({
        _profiles: [],
        _isLoading: false,
        _error: {},
        _profile: null,
    }),
    getters: {
        profiles: (state) => state._profiles,
        isLoading: (state) => state._isLoading,
        error: (state) => state._error,
        getProfile: (state) => state._profile,
    },
    actions: {
        setProfiles(profiles) {
            this._profiles = profiles;
        },

        setProfile(profile) {
            this._profile = profile;
        },

        async fetchProfiles() {
            this._isLoading = true;
            this._error = {};
            try {
                const response = await axios.get('/profiles');
                this.setProfiles(response.data);
            } catch (error) {
                if (error.response?.data) {
                    this._error = error.response?.data;
                }
            } finally {
                this._isLoading = false;
            }
        },

        async storeProfile(profile) {
            this._error = {};
            try {
                const response = await axios.post('/profiles', profile);
                this.setProfile(response.data);
            } catch (error) {
                if (error.response?.data) {
                    console.log(error.response?.data.errors);
                    this._error = error.response?.data?.errors;
                }
            }
        },

        async updateProfile(profile) {
            this._error = {};
            try {
                const response = await axios.put(`/profiles/${profile.id}`, profile);
                this.setProfile(response.data);
                this._profiles = this._profiles.map(profile => profile.id === response.data.id ? response.data : profile);
                this.setProfile(response.data);
            } catch (error) {
                if (error.response?.data) {
                    console.log(error.response?.data.errors);
                    this._error = error.response?.data?.errors;
                }
            }
        },
    },
});

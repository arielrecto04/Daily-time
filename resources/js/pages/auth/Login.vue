<script setup>
import { useAuthStore } from '@/stores';
import { storeToRefs } from 'pinia';

const authStore = useAuthStore();
const { credential, error, isLoading } = storeToRefs(authStore);

const handleLogin = () => {
    error.value = {};
    authStore.login();
};
</script>

<template>
    <div class="bg-gray-50 font-sans text-gray-800 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Logo and Header -->
            <div class="text-center mb-8">
                <router-link to="/" class="text-3xl font-bold text-blue-600">TimeFlow</router-link>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">
                    Sign in to your account
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Or <a href="#" class="font-medium text-blue-600 hover:text-blue-500">start your 14-day free
                        trial</a>
                </p>
            </div>

            <!-- Login Form -->
            <div class="bg-white shadow-lg rounded-xl p-8">
                <form @submit.prevent="handleLogin" class="space-y-6">

                    <template v-if="error.message">
                        <p class="mt-2 text-sm text-red-600">{{ error.message }}</p>
                    </template>
                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email address
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" v-model="credential.email" autocomplete="email"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="you@example.com" />
                        </div>

                        <template v-if="error.email">
                            <p class="mt-2 text-sm text-red-600">{{ error.email }}</p>
                        </template>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" v-model="credential.password"
                                autocomplete="current-password" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                        </div>

                        <template v-if="error.password">
                            <p class="mt-2 text-sm text-red-600">{{ error.password }}</p>
                        </template>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" v-model="credential.rememberMe"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                            <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                                Remember me
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                                Forgot your password?
                            </a>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" :disabled="isLoading"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ isLoading ? 'Loading...' : 'Sign in' }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer text -->
            <p class="mt-8 text-center text-sm text-gray-500">
                &copy; 2025 TimeFlow Inc. All rights reserved.
            </p>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, computed, watchEffect } from 'vue';
import { storeToRefs } from 'pinia';
import { useToast } from '@/utils';
import { useUsersStore } from '@/stores/useUsersStore';
import { useProfileStore } from '@/stores/useProfileStore';


const { showToast } = useToast();

const usersStore = useUsersStore();
const { error: usersError, users } = storeToRefs(usersStore);

const profileStore = useProfileStore();
const { error: profileError, getProfile } = storeToRefs(profileStore);

const props = defineProps({
    user: {
        type: Object,
        default: () => ({ name: '', email: '', profile: null })
    },
});

const emit = defineEmits(['close']);

const isSubmitting = ref(false);

const form = reactive({});
let initialFormState = {};
const newImagePreview = ref(null);
const imageInput = ref(null);

const isCreatingProfile = ref(false);

const isAddMode = computed(() => !props.user?.id);

const showProfileSections = computed(() => {
    return (props.user?.profile || isCreatingProfile.value);
});

const isDirty = computed(() => {
    return JSON.stringify(form) !== JSON.stringify(initialFormState) || newImagePreview.value !== null;
});

watchEffect(() => {
    const userData = props.user || {};
    const profileData = userData.profile || {};

    const fullFormData = {
        id: userData.id,
        name: userData.name || '',
        email: userData.email || '',
        password: '',
        password_confirmation: '',
        profile: {
            id: profileData.id || '',
            first_name: profileData.first_name || '',
            last_name: profileData.last_name || '',
            mobile: profileData.mobile || '',
            phone: profileData.phone || '',
            gender: profileData.gender || '',
            birthday: profileData.birthday || '',
            street: profileData.street || '',
            street_2: profileData.street_2 || '',
            barangay: profileData.barangay || '',
            city: profileData.city || '',
            region: profileData.region || '',
            image_url: profileData.image_url || 'https://placehold.co/128x128/E0E7FF/4F46E5?text=??',
            user_id: userData.id || '',
        }
    };

    Object.assign(form, fullFormData);
    initialFormState = JSON.parse(JSON.stringify(fullFormData));

    newImagePreview.value = null;
    isCreatingProfile.value = false;
});


function triggerImageUpload() {
    imageInput.value.click();
}

function handleImageChange(event) {
    const file = event.target.files[0];
    if (file) {
        newImagePreview.value = URL.createObjectURL(file);
        const reader = new FileReader();
        reader.onload = (e) => {
            form.profile.image_url = JSON.stringify(e.target.result);
        }

        reader.readAsDataURL(file);
    }
}

const saveChanges = async () => {
    isSubmitting.value = true;
    try {
        let successMessage = '';

        const payload = form;

        if (isAddMode.value) {
            await usersStore.storeUser(payload);
            successMessage = 'User created successfully!';

            emit('close');
            showToast({ icon: 'success', title: successMessage });
            return;
        }

        const updateUsers = users.value.map(user => {
            if (user.id == getProfile.value.user_id) {
                return user = {
                    ...user,
                    profile: getProfile.value
                }
            }
            return user;
        });


        await usersStore.updateUser(payload);

        if (showProfileSections.value && !props.user.profile) {
            await profileStore.storeProfile(payload.profile);
            successMessage = 'Profile added successfully!';
            emit('close');
            showToast({ icon: 'success', title: successMessage });
            usersStore.setUsers(updateUsers);
            return;
        }


        await profileStore.updateProfile(payload.profile);
        successMessage = 'Profile updated successfully!';


        usersStore.setUsers(updateUsers);

        emit('close');
        showToast({ icon: 'success', title: successMessage });


    } catch (error) {
        console.error("Save operation failed:", error);
        showToast({
            icon: 'error',
            title: 'Save failed. Please check the form for errors.'
        });
    } finally {
        isSubmitting.value = false;
    }
};
</script>

<template>
    <div class="bg-gray-50 min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="max-w-4xl mx-auto">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ isAddMode ? 'Create New User' : 'User Profile' }}
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">{{ isAddMode ?
                        'Fill in the details to create a new user account.' :
                        'Manage personal and account details.' }}</p>
                </div>
                <transition name="fade">
                    <button v-if="isDirty" @click="saveChanges" :disabled="isSubmitting"
                        class="mt-4 sm:mt-0 inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        {{ isSubmitting ? 'Saving...' : 'Save Changes' }}
                    </button>
                </transition>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-6">Account Information</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <label for="name" class="block text-sm font-medium text-gray-700">Display Name</label>
                    <div class="flex flex-col gap-2">
                        <input type="text" id="name" v-model="form.name" class="mt-1 block w-full p-2 text-sm" />
                        <span v-if="usersError.name" class="text-red-500 text-sm mt-1">{{ usersError?.name[0] }}</span>
                    </div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <div class="flex flex-col gap-2">
                        <input type="email" id="email" v-model="form.email" class="mt-1 block w-full p-2 text-sm" />
                        <span v-if="usersError.email" class="text-red-500 text-sm mt-1">{{ usersError?.email[0]
                            }}</span>
                    </div>
                    <template v-if="isAddMode">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="flex flex-col gap-2">
                            <input type="password" id="password" v-model="form.password"
                                class="mt-1 block w-full p-2 text-sm" />
                            <span v-if="usersError.password" class="text-red-500 text-sm mt-1">{{
                                usersError?.password[0]
                                }}</span>
                        </div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                            Password</label>
                        <div class="flex flex-col gap-2">
                            <input type="password" id="password_confirmation" v-model="form.password_confirmation"
                                class="mt-1 block w-full p-2 text-sm" />
                            <span v-if="usersError.password_confirmation" class="text-red-500 text-sm mt-1">{{
                                usersError?.password_confirmation[0] }}</span>
                        </div>
                    </template>
                </div>
            </div>

            <template v-if="!isAddMode">
                <div v-if="showProfileSections">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-6">Profile Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="relative group w-32 h-32 mx-auto md:mx-0">
                                <img :src="newImagePreview || form.profile.image_url" alt="Profile Picture"
                                    class="w-32 h-32 rounded-full object-cover shadow-lg">
                                <button @click="triggerImageUpload"
                                    class="absolute bottom-1 right-1 flex items-center justify-center w-8 h-8 bg-white rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-gray-100"
                                    aria-label="Edit profile picture">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z">
                                        </path>
                                    </svg>
                                </button>
                                <input type="file" ref="imageInput" @change="handleImageChange" class="hidden"
                                    accept="image/*" />
                            </div>
                            <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <label for="first_name" class="block text-sm font-medium text-gray-700">First
                                    Name</label>
                                <div class="flex flex-col gap-2">
                                    <input type="text" id="first_name" v-model="form.profile.first_name"
                                        class="mt-1 block w-full p-2 text-sm" />
                                    <span v-if="profileError.first_name" class="text-red-500 text-sm mt-1">{{
                                        profileError?.first_name[0] }}</span>
                                </div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                <div class="flex flex-col gap-2">
                                    <input type="text" id="last_name" v-model="form.profile.last_name"
                                        class="mt-1 block w-full p-2 text-sm" />
                                    <span v-if="profileError.last_name" class="text-red-500 text-sm mt-1">{{
                                        profileError?.last_name[0] }}</span>
                                </div>
                                <label for="mobile" class="block text-sm font-medium text-gray-700">Mobile
                                    Number</label>
                                <div class="flex flex-col gap-2">
                                    <input type="text" id="mobile" v-model="form.profile.mobile"
                                        class="mt-1 block w-full p-2 text-sm" />
                                    <span v-if="profileError.mobile" class="text-red-500 text-sm mt-1">{{
                                        profileError?.mobile[0] }}</span>
                                </div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <div class="flex flex-col gap-2">
                                    <input type="text" id="phone" v-model="form.profile.phone"
                                        class="mt-1 block w-full p-2 text-sm" />
                                    <span v-if="profileError.phone" class="text-red-500 text-sm mt-1">{{
                                        profileError?.phone[0] }}</span>
                                </div>
                                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                                <div class="flex flex-col gap-2">
                                    <select id="gender" v-model="form.profile.gender"
                                        class="mt-1 block w-full p-2 text-sm">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    <span v-if="profileError.gender" class="text-red-500 text-sm mt-1">{{
                                        profileError?.gender[0] }}</span>
                                </div>
                                <label for="birthday" class="block text-sm font-medium text-gray-700">Birthday</label>
                                <div class="flex flex-col gap-2">
                                    <input type="date" id="birthday" v-model="form.profile.birthday"
                                        class="mt-1 block w-full p-2 text-sm" />
                                    <span v-if="profileError.birthday" class="text-red-500 text-sm mt-1">{{
                                        profileError?.birthday[0] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-6">Address</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="sm:col-span-2">
                                <label for="street" class="block text-sm font-medium text-gray-700">Street
                                    Address</label>
                                <div class="flex flex-col gap-2">
                                    <input type="text" id="street" v-model="form.profile.street"
                                        class="mt-1 block w-full p-2 text-sm" />
                                    <span v-if="profileError.street" class="text-red-500 text-sm mt-1">{{
                                        profileError?.street[0] }}</span>
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="street_2" class="block text-sm font-medium text-gray-700">Apartment, suite,
                                    etc. (Optional)</label>
                                <input type="text" id="street_2" v-model="form.profile.street_2"
                                    class="mt-1 block w-full p-2 text-sm" />
                            </div>

                            <label for="barangay" class="block text-sm font-medium text-gray-700">Barangay</label>
                            <div class="flex flex-col gap-2">
                                <input type="text" id="barangay" v-model="form.profile.barangay"
                                    class="mt-1 block w-full p-2 text-sm" />
                                <span v-if="profileError.barangay" class="text-red-500 text-sm mt-1">{{
                                    profileError?.barangay[0] }}</span>
                            </div>

                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <div class="flex flex-col gap-2">
                                <input type="text" id="city" v-model="form.profile.city"
                                    class="mt-1 block w-full p-2 text-sm" />
                                <span v-if="profileError.city" class="text-red-500 text-sm mt-1">{{
                                    profileError?.city[0] }}</span>
                            </div>
                            <label for="region" class="block text-sm font-medium text-gray-700">Region</label>
                            <div class="flex flex-col gap-2">
                                <input type="text" id="region" v-model="form.profile.region"
                                    class="mt-1 block w-full p-2 text-sm" />
                                <span v-if="profileError.region" class="text-red-500 text-sm mt-1">{{
                                    profileError?.region[0] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center bg-white rounded-lg shadow-md p-8">
                    <h3 class="text-lg font-medium text-gray-800">No Profile Found</h3>
                    <p class="mt-2 text-sm text-gray-500">This user does not have a profile yet. Create one to add more
                        details.</p>
                    <button @click="isCreatingProfile = true" type="button"
                        class="mt-6 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Create Profile
                    </button>
                </div>
            </template>

        </div>
    </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>

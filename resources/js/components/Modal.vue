<script setup>
import { ref, watch, onMounted, onUnmounted, computed, nextTick } from 'vue';

// Define component props
const props = defineProps({
    isOpen: {
        type: Boolean,
        required: true,
    },
    maxWidth: {
        type: String,
        default: 'lg', // sm, md, lg, xl, 2xl
    },
    clazz: {
        type: String,
        default: '',
    },
    height: {
        type: String,
        default: 'h-auto',
    },
});

// Define component emits
const emit = defineEmits(['close']);

// A unique ID for ARIA attributes
const titleId = computed(() => `modal-title-${Math.random().toString(36).substr(2, 9)}`);

// Template ref for the modal panel
const modalPanel = ref(null);

// Map prop to Tailwind CSS class for responsive width
const maxWidthClass = computed(() => {
    return {
        'sm': 'max-w-sm',
        'md': 'max-w-md',
        'lg': 'max-w-lg',
        'xl': 'max-w-xl',
        '2xl': 'max-w-2xl',
    }[props.maxWidth];
});

// Function to emit the close event
const closeModal = () => {
    emit('close');
};

// Function to handle keydown events for accessibility
const handleKeydown = (event) => {
    if (event.key === 'Escape' && props.isOpen) {
        closeModal();
    }
};

// Add/remove event listeners when the component is mounted/unmounted
onMounted(() => {
    document.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeydown);
});

// Watch for the isOpen prop to change to manage focus and body scroll
watch(() => props.isOpen, (isOpen) => {
    if (isOpen) {
        // Focus the modal panel when it opens for accessibility
        nextTick(() => {
            modalPanel.value?.focus();
        });
        // Prevent background scrolling
        document.body.style.overflow = 'hidden';
    } else {
        // Restore background scrolling
        document.body.style.overflow = '';
    }
});
</script>


<template>
    <teleport to="body">
        <transition name="modal-transition">
            <div v-if="isOpen"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-sm bg-white/30"
                @click.self="closeModal" @keydown.esc="closeModal" role="dialog" aria-modal="true"
                :aria-labelledby="titleId">
                <!-- Modal Panel -->
                <div :class="`${maxWidthClass} ${props.height}`" class="relative w-full mx-auto bg-white rounded-xl shadow-2xl flex flex-col overflow-y-auto "
                    ref="modalPanel" tabindex="-1">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-5 border-b border-gray-200">
                        <slot name="header">
                            <h3 :id="titleId" class="text-lg font-medium leading-6 text-gray-800">
                                Modal Title
                            </h3>
                        </slot>
                        <button type="button"
                            class="p-1 text-gray-400 rounded-full hover:bg-gray-200 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
                            @click="closeModal" aria-label="Close modal">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 flex-1">
                        <slot name="body">
                            <p class="text-sm text-gray-600">
                                This is the default modal body. You can replace this with your own content for a more
                                dynamic and engaging user experience.
                            </p>
                        </slot>
                    </div>

                    <!-- Modal Footer -->
                    <div
                        class="flex items-center justify-end p-5 space-x-3 bg-gray-50 border-t border-gray-200 rounded-b-xl">
                        <slot name="footer">
                            <button @click="closeModal" type="button"
                                class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                                Cancel
                            </button>
                            <button @click="closeModal" type="button"
                                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                                Accept
                            </button>
                        </slot>
                    </div>
                </div>
            </div>
        </transition>
    </teleport>
</template>



<style scoped>
/* Define the enter/leave transitions for the modal */
.modal-transition-enter-active,
.modal-transition-leave-active {
    transition: opacity 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}

.modal-transition-enter-from,
.modal-transition-leave-to {
    opacity: 0;
}

/* Animate the panel itself with a slide and fade */
.modal-transition-enter-active .relative,
.modal-transition-leave-active .relative {
    transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}

.modal-transition-enter-from .relative,
.modal-transition-leave-to .relative {
    opacity: 0;
    transform: scale(0.95) translateY(20px);
}
</style>

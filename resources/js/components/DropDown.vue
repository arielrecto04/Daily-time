<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const isOpen = ref(false);
const dropdown = ref(null); // Template ref for the main container

// --- Event Handling ---

// Toggles the dropdown visibility. A single click is more intuitive than a double-click.
const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
};

// A dedicated function to ensure the dropdown closes.
const closeDropdown = () => {
  isOpen.value = false;
};

// Closes the dropdown if the user clicks outside of it.
// Using 'mousedown' instead of 'click' can prevent some race conditions.
const handleClickOutside = (event) => {
  if (dropdown.value && !dropdown.value.contains(event.target)) {
    closeDropdown();
  }
};

// Closes the dropdown if the user presses the Escape key.
const handleKeydown = (event) => {
  if (event.key === 'Escape' && isOpen.value) {
    closeDropdown();
  }
};

// Add/remove global event listeners for closing the dropdown.
onMounted(() => {
  document.addEventListener('mousedown', handleClickOutside);
  document.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
  document.removeEventListener('mousedown', handleClickOutside);
  document.removeEventListener('keydown', handleKeydown);
});
</script>

<template>
  <div class="relative inline-block text-left" ref="dropdown">

    <!-- The trigger element. Changed to a single click for better UX. -->
    <div @click="toggleDropdown" class="cursor-pointer">
      <slot></slot>
    </div>

    <!-- Dropdown Panel -->
    <transition
      enter-active-class="transition ease-out duration-100"
      enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <div
        v-if="isOpen"

        class="absolute left-1/2 -translate-x-1/2 z-50 mt-2 w-56 origin-top rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none"
      >
        <!-- The content for the dropdown menu is provided by the parent using the 'content' slot. -->
        <!-- We wrap it in a div and add a click listener to close the menu after an item is selected. -->
        <div @click="closeDropdown">
          <slot name="content"></slot>
        </div>
      </div>
    </transition>
  </div>
</template>

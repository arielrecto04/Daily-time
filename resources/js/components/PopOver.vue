<script setup>
import { ref, onMounted, onUnmounted, watch, nextTick } from 'vue';

// --- Component Props and Emits ---
const props = defineProps({
  options: {
    type: Array,
    default: () => []
  }
});
const emit = defineEmits(['option-selected']);

// --- Component State ---
const isOpen = ref(false);
const popover = ref(null); // Template ref for the trigger element
const popoverContent = ref(null); // Template ref for the popover panel itself
const popoverPosition = ref({ top: '0px', left: '0px' }); // Position state

// --- Event Handling & Logic ---
const togglePopover = () => {
  isOpen.value = !isOpen.value;
};

const closePopover = () => {
  isOpen.value = false;
};

const selectOption = (option) => {
  emit('option-selected', option);
  closePopover();
};

// Calculates the correct position for the teleported popover panel
const calculatePosition = () => {
  const triggerEl = popover.value;
  if (!triggerEl) return;

  const rect = triggerEl.getBoundingClientRect();
  
  // Position the popover below the trigger element
  popoverPosition.value = {
    top: `${rect.bottom + window.scrollY}px`,
    left: `${rect.left + window.scrollX}px`
  };
};

// Watch for the popover opening and calculate its position
watch(isOpen, (newValue) => {
  if (newValue) {
    // Use nextTick to ensure the DOM is updated before calculating the position
    nextTick(() => {
      calculatePosition();
    });
  }
});

// Closes the popover if the user clicks outside of it
const handleClickOutside = (event) => {
  // Check if the click is outside both the trigger and the popover content
  if (
    popover.value && !popover.value.contains(event.target) &&
    popoverContent.value && !popoverContent.value.contains(event.target)
  ) {
    closePopover();
  }
};

const handleKeydown = (event) => {
  if (event.key === 'Escape' && isOpen.value) {
    closePopover();
  }
};

// Add/remove global event listeners
onMounted(() => {
  document.addEventListener('mousedown', handleClickOutside);
  document.addEventListener('keydown', handleKeydown);
  window.addEventListener('resize', calculatePosition); // Recalculate on resize
});

onUnmounted(() => {
  document.removeEventListener('mousedown', handleClickOutside);
  document.removeEventListener('keydown', handleKeydown);
  window.removeEventListener('resize', calculatePosition);
});
</script>

<template>
  <div class="relative inline-block text-left" ref="popover">

    <!-- The trigger element is provided by the parent via the default slot -->
    <div @click="togglePopover" class="cursor-pointer">
      <slot>
        <!-- Default trigger button if none is provided -->
        <button type="button" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
          Options
          <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
          </svg>
        </button>
      </slot>
    </div>

    <!-- 
      Use <teleport> to move the popover panel to the end of the <body>.
      This allows it to escape the table's overflow container and render on top of everything.
    -->
    <teleport to="body">
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
          ref="popoverContent"
          class="absolute z-50 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
          role="menu"
          aria-orientation="vertical"
          :style="{ top: popoverPosition.top, left: popoverPosition.left }"
        >
          <div class="py-1">
            <a
              v-for="option in options"
              :key="option.value"
              @click.prevent="selectOption(option)"
              href="#"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
              role="menuitem"
            >
              {{ option.name }}
            </a>
            <p v-if="!options.length" class="px-4 py-2 text-sm text-gray-500">No options available.</p>
          </div>
        </div>
      </transition>
    </teleport>
  </div>
</template>


<script setup lang="ts">
import { computed, type PropType } from 'vue';
type ButtonVariant =
  | 'primary'
  | 'secondary'
  | 'success'
  | 'danger'
  | 'warning'
  | 'info'
  | 'light'
  | 'dark'
  | 'link';

type ButtonSize = 'xs' | 'sm' | 'md' | 'lg' | 'xl';
type ButtonType = 'button' | 'submit' | 'reset';

const props = defineProps({
  /**
   * The variant of the button
   * @default 'primary'
   */
  variant: {
    type: String as PropType<ButtonVariant>,
    default: 'primary',
    validator: (value: string) =>
      ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark', 'link'].includes(value)
  },

  /**
   * The size of the button
   * @default 'md'
   */
  size: {
    type: String as PropType<ButtonSize>,
    default: 'md',
    validator: (value: string) =>
      ['xs', 'sm', 'md', 'lg', 'xl'].includes(value)
  },

  /**
   * The HTML button type
   * @default 'button'
   */
  type: {
    type: String as PropType<ButtonType>,
    default: 'button',
    validator: (value: string) =>
      ['button', 'submit', 'reset'].includes(value)
  },

  /**
   * Display loading state
   * @default false
   */
  loading: {
    type: Boolean,
    default: false
  },

  /**
   * Disable the button
   * @default false
   */
  disabled: {
    type: Boolean,
    default: false
  },

  /**
   * Display full width
   * @default false
   */
  block: {
    type: Boolean,
    default: false
  },

  /**
   * Display outline style
   * @default false
   */
  outline: {
    type: Boolean,
    default: false
  },

  /**
   * Display pill style (rounded-full)
   * @default false
   */
  pill: {
    type: Boolean,
    default: false
  },

  /**
   * Display icon only (square aspect ratio)
   * @default false
   */
  icon: {
    type: Boolean,
    default: false
  },

  /**
   * Custom class to be applied to the button
   */
  customClass: {
    type: String,
    default: ''
  }
});

const emit = defineEmits<{
  (e: 'click', event: MouseEvent): void;
}>();

const baseClasses = 'inline-flex items-center justify-center font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed';

const variantClasses = computed(() => {
  const variants = {
    primary: {
      solid: 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
      outline: 'border border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-blue-500',
    },
    secondary: {
      solid: 'bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500',
      outline: 'border border-gray-600 text-gray-600 hover:bg-gray-50 focus:ring-gray-500',
    },
    success: {
      solid: 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500',
      outline: 'border border-green-600 text-green-600 hover:bg-green-50 focus:ring-green-500',
    },
    danger: {
      solid: 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
      outline: 'border border-red-600 text-red-600 hover:bg-red-50 focus:ring-red-500',
    },
    warning: {
      solid: 'bg-yellow-500 text-white hover:bg-yellow-600 focus:ring-yellow-500',
      outline: 'border border-yellow-500 text-yellow-600 hover:bg-yellow-50 focus:ring-yellow-500',
    },
    info: {
      solid: 'bg-cyan-500 text-white hover:bg-cyan-600 focus:ring-cyan-500',
      outline: 'border border-cyan-500 text-cyan-600 hover:bg-cyan-50 focus:ring-cyan-500',
    },
    light: {
      solid: 'bg-gray-100 text-gray-800 hover:bg-gray-200 focus:ring-gray-300',
      outline: 'border border-gray-200 text-gray-700 hover:bg-gray-50 focus:ring-gray-300',
    },
    dark: {
      solid: 'bg-gray-800 text-white hover:bg-gray-900 focus:ring-gray-500',
      outline: 'border border-gray-800 text-gray-800 hover:bg-gray-50 focus:ring-gray-500',
    },
    link: {
      solid: 'text-blue-600 hover:text-blue-800 underline focus:ring-blue-500',
      outline: 'text-blue-600 hover:text-blue-800 underline focus:ring-blue-500',
    },
  };

  const style = props.outline ? 'outline' : 'solid';
  return variants[props.variant][style];
});

const sizeClasses = computed(() => {
  const sizes = {
    xs: 'px-2.5 py-1.5 text-xs',
    sm: 'px-3 py-2 text-sm',
    md: 'px-4 py-2 text-sm',
    lg: 'px-6 py-3 text-base',
    xl: 'px-8 py-4 text-lg',
  };

  // Adjust padding for icon-only buttons
  if (props.icon) {
    return {
      xs: 'p-1',
      sm: 'p-1.5',
      md: 'p-2',
      lg: 'p-2.5',
      xl: 'p-3',
    }[props.size];
  }

  return sizes[props.size];
});

const buttonClasses = computed(() => {
  return [
    baseClasses,
    variantClasses.value,
    sizeClasses.value,
    {
      'w-full': props.block,
      'rounded-full': props.pill,
      'rounded-md': !props.pill,
      'aspect-square': props.icon,
      'opacity-75 cursor-wait': props.loading,
    },
    props.customClass,
  ];
});

const handleClick = (event: MouseEvent) => {
  if (!props.loading && !props.disabled) {
    emit('click', event);
  }
};
</script>

<template>
  <button
    :type="type"
    :class="buttonClasses"
    :disabled="disabled || loading"
    @click="handleClick"
    v-bind="$attrs"
  >
    <!-- Loading Spinner -->
    <!-- <Spinner
      v-if="loading"
      class="animate-spin -ml-1 mr-2 h-4 w-4"
      :class="{
        'h-3 w-3': size === 'xs',
        'h-4 w-4': size === 'sm' || size === 'md',
        'h-5 w-5': size === 'lg' || size === 'xl',
        '!m-0': !$slots.default
      }"
    /> -->

    <!-- Button Content -->
    <span
      class="inline-flex items-center"
      :class="{ 'opacity-0': loading && $slots.default }"
    >
      <!-- Left Icon Slot -->
      <span v-if="$slots.prefix" class="mr-2">
        <slot name="prefix" />
      </span>

      <!-- Default Slot (Button Text) -->
      <slot />

      <!-- Right Icon Slot -->
      <span v-if="$slots.suffix" class="ml-2">
        <slot name="suffix" />
      </span>
    </span>
  </button>
</template>

<style scoped>
/* Smooth transitions for all interactive states */
button {
  transition-property: color, background-color, border-color, opacity, transform, box-shadow;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}

/* Scale down slightly when button is pressed */
button:active:not(:disabled) {
  transform: scale(0.98);
}

/* Hide spinner when content is not present */
button:empty .animate-spin {
  margin: 0;
}
</style>

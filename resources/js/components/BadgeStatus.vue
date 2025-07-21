
<script setup>
import { computed } from 'vue';

const props = defineProps({
  // Content of the badge
  text: {
    type: String,
    default: '',
  },
  // Color variants
  variant: {
    type: String,
    default: 'primary',
    validator: (value) => [
      'primary', 'secondary', 'success', 'danger',
      'warning', 'info', 'light', 'dark', 'gray'
    ].includes(value),
  },
  // Size variants
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['xs', 'sm', 'md', 'lg'].includes(value),
  },
  // Pill style (rounded-full)
  pill: {
    type: Boolean,
    default: false,
  },
  // Outline style (border only)
  outline: {
    type: Boolean,
    default: false,
  },
  // With dot indicator
  dot: {
    type: Boolean,
    default: false,
  },
  // Custom class for additional styling
  customClass: {
    type: String,
    default: '',
  },
});

// Dynamic classes based on props
const badgeClasses = computed(() => {
  const base = [
    'inline-flex items-center font-medium transition-colors',
    props.pill ? 'rounded-full' : 'rounded-md',
    props.customClass,
  ];

  // Size classes
  const sizes = {
    xs: ['text-xs', 'px-2 py-0.5', props.dot ? 'pl-1.5' : 'px-2'],
    sm: ['text-xs', 'px-2.5 py-0.5', props.dot ? 'pl-2' : 'px-2.5'],
    md: ['text-sm', 'px-2.5 py-0.5', props.dot ? 'pl-2' : 'px-2.5'],
    lg: ['text-sm', 'px-3 py-1', props.dot ? 'pl-2.5' : 'px-3'],
  };

  // Color classes
  const variants = {
    primary: props.outline
      ? 'text-blue-700 bg-blue-50 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800'
      : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
    secondary: props.outline
      ? 'text-purple-700 bg-purple-50 border border-purple-200 dark:bg-purple-900/30 dark:text-purple-300 dark:border-purple-800'
      : 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
    success: props.outline
      ? 'text-green-700 bg-green-50 border border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-800'
      : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
    danger: props.outline
      ? 'text-red-700 bg-red-50 border border-red-200 dark:bg-red-900/30 dark:text-red-300 dark:border-red-800'
      : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
    warning: props.outline
      ? 'text-yellow-700 bg-yellow-50 border border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-300 dark:border-yellow-800'
      : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/80 dark:text-yellow-200',
    info: props.outline
      ? 'text-cyan-700 bg-cyan-50 border border-cyan-200 dark:bg-cyan-900/30 dark:text-cyan-300 dark:border-cyan-800'
      : 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-200',
    light: props.outline
      ? 'text-gray-700 bg-gray-50 border border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600'
      : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
    dark: props.outline
      ? 'text-gray-100 bg-gray-800 border border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700'
      : 'bg-gray-800 text-white dark:bg-gray-900 dark:text-gray-100',
    gray: props.outline
      ? 'text-gray-700 bg-gray-100 border border-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600'
      : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
  };

  // Dot colors
  const dotColors = {
    primary: 'bg-blue-500',
    secondary: 'bg-purple-500',
    success: 'bg-green-500',
    danger: 'bg-red-500',
    warning: 'bg-yellow-500',
    info: 'bg-cyan-500',
    light: 'bg-gray-400',
    dark: 'bg-gray-800',
    gray: 'bg-gray-500',
  };

  return [
    ...base,
    ...sizes[props.size],
    variants[props.variant],
    { 'border': props.outline },
  ];
});

const dotClasses = computed(() => {
  return [
    'inline-block rounded-full mr-1.5',
    props.size === 'xs' ? 'w-1.5 h-1.5' : 'w-2 h-2',
    props.dot ? 'inline-block' : 'hidden',
    props.outline ? 'opacity-70' : '',
  ];
});
</script>

<template>
  <span :class="badgeClasses">
    <span
      v-if="dot"
      :class="dotClasses"
      :style="{ backgroundColor: dotColors[variant] }"
    ></span>
    <slot>{{ text }}</slot>
  </span>
</template>


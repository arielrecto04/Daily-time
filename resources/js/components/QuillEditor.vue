<script setup>
import { ref, watch, onMounted, onBeforeUnmount } from 'vue'

// Props definition
const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  },
  placeholder: {
    type: String,
    default: 'Start writing...'
  }
})

// Emits definition
const emit = defineEmits(['update:modelValue', 'editor-change', 'editor-blur'])

// Reactive state
const editorContent = ref(props.modelValue)

// Editor configuration
const toolbarOptions = [
  ['bold', 'italic', 'underline', 'strike'],
  ['blockquote', 'code-block'],
  [{ list: 'ordered' }, { list: 'bullet' }],
  [{ indent: '-1' }, { indent: '+1' }],
  [{ header: [1, 2, 3, 4, 5, 6, false] }],
  [{ color: [] }, { background: [] }],
  [{ font: [] }],
  [{ align: [] }],
  ['clean'],
  ['link', 'image']
]

// Watch for external changes
watch(
  () => props.modelValue,
  (newValue) => {
    if (newValue !== editorContent.value) {
      editorContent.value = newValue
    }
  }
)

// Watch for internal changes
watch(
  () => editorContent.value,
  (newValue) => {
    emit('update:modelValue', newValue)
  }
)

// Event handlers
const handleContentChange = (content) => {
  emit('editor-change', content)
}

const handleEditorBlur = ({ editor, event }) => {
  emit('editor-blur', { content: editorContent.value, event })
}

// Lifecycle hooks
onMounted(() => {
  if (props.modelValue) {
    editorContent.value = props.modelValue
  }
})

onBeforeUnmount(() => {
  editorContent.value = ''
})
</script>



<template>
  <div class="editor-wrapper">
    <quill-editor
      v-model:content="editorContent"
      :toolbar="toolbarOptions"
      :placeholder="placeholder"
      contentType="html"
      @update:content="handleContentChange"
      @blur="handleEditorBlur"
      theme="snow"
    />
  </div>
</template>



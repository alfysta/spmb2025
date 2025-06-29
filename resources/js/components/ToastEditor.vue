<template>
    <div ref="editorElement"></div>
</template>

<script setup>
import { Editor } from '@toast-ui/editor';
import '@toast-ui/editor/dist/toastui-editor.css';

import { onBeforeUnmount, onMounted, ref, watch } from 'vue';

const props = defineProps({
    modelValue: String,
});
const emit = defineEmits(['update:modelValue']);

const editorElement = ref(null);
let editorInstance = null;

onMounted(() => {
    editorInstance = new Editor({
        el: editorElement.value,
        height: '500px',
        initialEditType: 'wysiwyg',
        previewStyle: 'vertical',
        placeholder: 'Please enter text.',
        theme: 'dark',
        initialValue: props.modelValue || '',
        events: {
            change() {
                emit('update:modelValue', editorInstance.getMarkdown());
            },
        },
    });
});

onBeforeUnmount(() => {
    if (editorInstance) editorInstance.destroy();
});

watch(
    () => props.modelValue,
    (newVal) => {
        if (editorInstance && editorInstance.getMarkdown() !== newVal) {
            editorInstance.setMarkdown(newVal);
        }
    },
);
</script>

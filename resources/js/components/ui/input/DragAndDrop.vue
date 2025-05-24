<script setup lang="ts">
import { computed, ref, type HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'
import { useVModel } from '@vueuse/core'
import { SquareDashedMousePointer } from 'lucide-vue-next';
import SubText from '@/components/SubText.vue';

import { Image, FilePenLine, Video, Trash } from 'lucide-vue-next';

const props = defineProps<{
  defaultValue?: string | number
  modelValue?: string | number
  class?: HTMLAttributes['class']
  size_svg: number
}>();

const emits = defineEmits<{
  (e: 'update:modelValue', payload: string | number): void
  (e: 'files-selected', files: FileList[]): void;
}>();

const modelValue = useVModel(props, 'modelValue', emits, {
  passive: true,
  defaultValue: props.defaultValue,
});

const isDragging = ref(false);
const file = ref({ files: ref<FileList[]>([]) });
const documents = ref<any[]>([]);

function dragover(e: Event) {
    e.preventDefault();
    isDragging.value = true;
}

function dragleave() {
    isDragging.value = false;
}

function drop(e: any) {
    e.preventDefault();
    file.value.files = e.dataTransfer.files;
    onChange();
    isDragging.value = false;
}

function onChange() {
    if (file.value) {
        documents.value.push(file.value.files[0]);
        emits('files-selected', documents.value);
    }
}

function removeFile(index: number) {
    documents.value.splice(index, 1);
}

</script>

<template>
    <div class="flex flex-col p-2 mx-5 text-center rounded-xl"
        :class="{ 'border-4 border-dashed border-gray-600' : isDragging }"
        @dragover="dragover" 
        @dragleave="dragleave()"
        @drop="drop"
        @click="">

        <input
            type="file"
            multiple
            name="file"
            id="fileInput"
            class="hidden-input"
            style="color:transparent; height: 0px;"
            @change="onChange"
            ref="file"
        />

        <label for="fileInput" class="flex justify-center">
            <SquareDashedMousePointer :size="size_svg" color="#77767b" />
        </label>

        <SubText>Arraste ou clique no ícone</SubText>

        <div v-if="documents.length > 0">
            <div v-for="(documento, index) in documents" class="flex flex-row justify-between">
                <div class="text-center">
                    <Image v-if="documento.type.includes('image')" />
                    <FilePenLine v-if="documento.type.includes('text')" />
                    <Video v-if="documento.type.includes('video')" />
                </div>
                <SubText color="text-white">{{ documento.name }}</SubText>
                <Trash color="#ed333b" class="cursor-pointer" @click="removeFile(index)" />
            </div>
        </div>
    </div>
</template>
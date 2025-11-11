<!-- src/components/SuccessToast.vue -->
<template>
    <div v-if="toast.visible" class="fixed inset-0 t flex items-start justify-center pointer-events-none z-50 p-4">
        <div class="max-w-md w-full mx-auto z-10 bg-transparent pointer-events-auto">
            <div class="rounded-md w-full bg-slate-50 overflow-hidden">
                <div class="flex justify-between items-center bg-green-600 text-white px-3 py-2">
                    <p class="text-sm font-medium">Succès</p>
                    <button @click="hide" class="text-white text-xl leading-none">&times;</button>
                </div>

                <div class="bg-white shadow-xl border-2 p-3 rounded-b-md">
                    <!-- utilise message du store -->
                    <p class="text-sm text-gray-700">{{ toast.message }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useToastStore, hideToast } from '@/helpers.js';

// reactive store
const toast = useToastStore();

function hide() {
    hideToast();
}
</script>

<style scoped>
/* si tu veux positionner différemment, change les classes Tailwind */
</style>

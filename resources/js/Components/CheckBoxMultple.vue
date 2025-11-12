<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {              // ce que v-model sur le composant lira/écrira
        type: [Array, Boolean, String, Number, Object],
        default: undefined
    },
    value: {                   // valeur de cette case (pour le mode tableau)
        type: [String, Number, Boolean, Object],
        default: null
    }
});
const emit = defineEmits(['update:modelValue']);

// gère le clic sur l'input
function onChange(e) {
    const checked = e.target.checked;

    // si modelValue est un tableau => mode multiple
    if (Array.isArray(props.modelValue)) {
        const arr = Array.from(props.modelValue); // copie
        const val = props.value;
        const idx = arr.indexOf(val);
        if (checked && idx === -1) arr.push(val);
        if (!checked && idx !== -1) arr.splice(idx, 1);
        emit('update:modelValue', arr);
        return;
    }

    // sinon on émet simplement le booléen (mode simple)
    emit('update:modelValue', checked);
}
</script>

<template>
    <input
        type="checkbox"
        :value="value"
        :checked="Array.isArray(modelValue) ? modelValue.includes(value) : !!modelValue"
        @change="onChange"
        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
    />
</template>

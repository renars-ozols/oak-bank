<script setup>
import {onMounted, ref} from 'vue';

defineProps({
    modelValue: String,
    options: {
        type: Array,
        default: []
    },
    valueProp: {
        type: String,
        default: 'symbol'
    },
    displayProp: {
        type: String,
        default: 'symbol'
    }
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({focus: () => input.value.focus()});
</script>

<template>
    <select
        ref="input"
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
        <template v-for="option in options">
            <option :value="option[valueProp]">{{ option[displayProp] }} {{ option.currency }} {{
                    option.balance
                }}
            </option>
        </template>
    </select>
</template>

<script setup>
import TextInput from "./TextInput.vue";

defineProps({
    searchOne: String,
    searchOnePlaceholder: String,
    searchTwo: String,
    searchTwoPlaceholder: String,
    startDate: String,
    endDate: String
});

const emit = defineEmits(['update:searchOne', 'update:searchTwo', 'update:startDate', 'update:endDate', 'reset']);

</script>
<template>
    <div class="flex align-middle">
        <TextInput
            id="search-one"
            :value="searchOne"
            @input="$emit('update:searchOne', $event.target.value)"
            type="text"
            class="mt-1 ml-2 block"
            :placeholder="searchOnePlaceholder"
        />

        <TextInput
            id="search-two"
            :value="searchTwo"
            @input="$emit('update:searchTwo', $event.target.value)"
            type="text"
            class="mt-1 ml-2 block"
            :placeholder="searchTwoPlaceholder"
        />

        <TextInput
            id="start_date"
            :value="startDate"
            @input="$emit('update:startDate', $event.target.value)"
            type="date"
            class="mt-1 ml-2 block"
            placeholder="Start date..."
        />

        <TextInput
            id="end_date"
            :value="endDate"
            @input="$emit('update:endDate', $event.target.value)"
            type="date"
            class="mt-1 ml-2 block"
            placeholder="End date..."
        />

        <button type="button" @click="$emit('reset')" class="ml-2 self-center text-gray-500">Reset</button>
    </div>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';

const props = defineProps({
    accounts: Array,
});
</script>

<template>
    <AppLayout title="Overview">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Overview
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <ul class="list-none">
                        <li v-for="account in accounts" :key="account.id" class="text-xl font-bold mx-4">
                            <span class="mr-4">{{ account.name }}</span>
                            <span class="mr-4">{{ account.number }}</span>
                            <span class="mr-4">{{ account.currency }}</span>
                            <span>{{ account.balance }}</span>
                        </li>
                    </ul>

                    <div class="mt-10 p-4 text-xl font-bold">Transactions:</div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

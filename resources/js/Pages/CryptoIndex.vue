<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link} from '@inertiajs/inertia-vue3';
import {formatMoney} from "@/helpers";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "../Components/TextInput.vue";
import {reactive} from "vue";
import {Inertia} from "@inertiajs/inertia";
import InputError from "../Components/InputError.vue";

const props = defineProps({
    cryptos: Array,
});

const searchForm = reactive({
    search: '',
    error: '',
});

const onSearch = () => {
    if (searchForm.search.length > 0) {
        searchForm.error = '';
        Inertia.get(route('crypto.search'), {search: search.value});
        return;
    }
    searchForm.error = 'Please enter a search term';
}

</script>

<template>
    <AppLayout title="Crypto">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="w-1/2 mx-auto mb-4">
                    <div class="flex">
                        <TextInput
                            id="search"
                            type="text"
                            v-model="searchForm.search"
                            placeholder="Search crypto by symbol..."
                            class="mr-1 block w-full"
                            required
                        />
                        <PrimaryButton @click="onSearch" type="submit">search</PrimaryButton>
                    </div>
                    <InputError class="mt-1 w-full" :message="searchForm.error"/>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">#</th>
                            <th class="pb-4 pt-6 px-6">Name</th>
                            <th class="pb-4 pt-6 px-6">Price</th>
                            <th class="pb-4 pt-6 px-6">1h %</th>
                            <th class="pb-4 pt-6 px-6">24h %</th>
                            <th class="pb-4 pt-6 px-6">7d %</th>
                            <th class="pb-4 pt-6 px-6"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(crypto, index) in cryptos" :key="crypto.id"
                            class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4 focus:text-indigo-500"
                                      :href="`/crypto/${crypto.id}`">
                                    {{ index + 1 }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/crypto/${crypto.id}`"
                                      tabindex="-1">
                                    <img v-bind:src="crypto.logo" alt={{crypto.name}} width="45" class="rounded-full">
                                    <span class="ml-2 font-bold text-xl">{{ crypto.name }}</span>
                                    <span
                                        class="ml-2 font-semibold bg-gray-300 text-gray-800 rounded-full px-3 py-1 text-sm">{{
                                            crypto.symbol
                                        }}</span>
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/crypto/${crypto.id}`"
                                      tabindex="-1">
                                    {{ formatMoney(crypto.price) }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/crypto/${crypto.id}`"
                                      tabindex="-1">

                                    <span v-if="crypto.percentChange1h < 0" class="text-red-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                          <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                        {{ crypto.percentChange1h.toFixed(2) }}%
                                    </span>
                                    <span v-else class="text-green-500 flex items-center">
                                        <!-- svg chevron up direction-->
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                          <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                                        </svg>
                                        +{{ crypto.percentChange1h.toFixed(2) }}%
                                    </span>
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/crypto/${crypto.id}`"
                                      tabindex="-1">

                                    <span v-if="crypto.percentChange24h < 0" class="text-red-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                          <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                        {{ crypto.percentChange24h.toFixed(2) }}%
                                    </span>
                                    <span v-else class="text-green-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                          <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                                        </svg>
                                        +{{ crypto.percentChange24h.toFixed(2) }}%
                                    </span>
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/crypto/${crypto.id}`"
                                      tabindex="-1">

                                    <span v-if="crypto.percentChange7d < 0" class="text-red-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                          <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                        {{ crypto.percentChange7d.toFixed(2) }}%
                                    </span>
                                    <span v-else class="text-green-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                          <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                                        </svg>
                                        +{{ crypto.percentChange7d.toFixed(2) }}%
                                    </span>
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link :href="`/crypto/${crypto.id}`"
                                      class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                    Trade
                                </Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

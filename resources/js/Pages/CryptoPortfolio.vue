<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link} from '@inertiajs/inertia-vue3';
import {formatMoney, formatDate} from "@/helpers";
import TransactionFilter from "@/Components/TransactionFilter.vue";
import {reactive, watch} from "vue";
import throttle from "lodash/throttle";
import {Inertia} from "@inertiajs/inertia";
import pickBy from "lodash/pickBy";
import Pagination from "@/Components/Pagination.vue";
import PrimaryButton from "../Components/PrimaryButton.vue";

const props = defineProps({
    cryptos: Array,
    transactions: Object,
});

const form = reactive({
    search_crypto: '',
    search_account: '',
    start_date: '',
    end_date: '',
});
const resetFilters = () => {
    form.search_crypto = '';
    form.search_account = '';
    form.start_date = '';
    form.end_date = '';
};

const throttled = throttle((form) => {
    Inertia.get(route('user-cryptos.index'), pickBy(form), {
        preserveScroll: true,
        preserveState: true,
        replace: true,
    });
}, 500);

watch(form, (form) => {
    throttled(form);
});

</script>

<template>
    <AppLayout title="Crypto-portfolio">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crypto portfolio
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">#</th>
                            <th class="pb-4 pt-6 px-6">Name</th>
                            <th class="pb-4 pt-6 px-6">Amount</th>
                            <th class="pb-4 pt-6 px-6">Account</th>
                            <th class="pb-4 pt-6 px-6">Current value</th>
                            <th class="pb-4 pt-6 px-6">Current price</th>
                            <th class="pb-4 pt-6 px-6">Average buying price</th>
                            <th class="pb-4 pt-6 px-6"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(crypto, index) in cryptos" :key="crypto.id"
                            class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4 focus:text-indigo-500"
                                      :href="`/crypto/${crypto.crypto_id}`">
                                    {{ index + 1 }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/crypto/${crypto.crypto_id}`"
                                      tabindex="-1">
                                    <img v-bind:src="crypto.logo" alt={{crypto.name}} width="45" class="rounded-full">
                                    <span class="ml-2 font-bold text-xl">{{ crypto.name }}</span>
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/crypto/${crypto.crypto_id}`"
                                      tabindex="-1">
                                    {{ Number(crypto.amount).toFixed(4) }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/crypto/${crypto.crypto_id}`"
                                      tabindex="-1">
                                    {{ crypto.account }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/crypto/${crypto.crypto_id}`"
                                      tabindex="-1">
                                    {{ formatMoney(crypto.current_value, crypto.currency) }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`crypto/${crypto.crypto_id}`"
                                      tabindex="-1">
                                    {{ formatMoney(crypto.current_price, crypto.currency) }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/crypto/${crypto.crypto_id}`"
                                      tabindex="-1">

                                    <div v-if="crypto.average_price > crypto.current_price"
                                         class="text-red-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                        <span>{{ formatMoney(Number(crypto.average_price), crypto.currency) }}</span>
                                        <span class="ml-1">({{
                                                Number(((crypto.current_price - crypto.average_price) / crypto.average_price) * 100).toFixed(2)
                                            }}%)</span>
                                    </div>

                                    <span v-else class="text-green-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                          <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                                        </svg>
                                        {{ formatMoney(Number(crypto.average_price), crypto.currency) }}
                                        <span class="ml-1">(+{{
                                                Number(((crypto.current_price - crypto.average_price) / crypto.average_price) * 100).toFixed(2)
                                            }}%)</span>
                                    </span>

                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4 focus:text-indigo-500"
                                      :href="`/crypto/${crypto.crypto_id}`">
                                    <PrimaryButton>Trade</PrimaryButton>
                                </Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-5 max-w-7xl mx-auto">
                    <TransactionFilter
                        :endDate="form.end_date"
                        :searchOne="form.search_account"
                        :searchTwo="form.search_crypto"
                        :startDate="form.start_date"
                        searchOnePlaceholder="Search by account..."
                        searchTwoPlaceholder="Search by crypto..."
                        @reset="resetFilters"
                        @update:searchOne="form.search_account = $event"
                        @update:searchTwo="form.search_crypto = $event"
                        @update:startDate="form.start_date = $event"
                        @update:endDate="form.end_date = $event"
                    />
                </div>

                <div class="mt-5 bg-white overflow-hidden shadow-md sm:rounded-lg">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">Id</th>
                            <th class="pb-4 pt-6 px-6">Account</th>
                            <th class="pb-4 pt-6 px-6">Type</th>
                            <th class="pb-4 pt-6 px-6">Name</th>
                            <th class="pb-4 pt-6 px-6">Amount</th>
                            <th class="pb-4 pt-6 px-6">Price per crypto</th>
                            <th class="pb-4 pt-6 px-6">Total</th>
                            <th class="pb-4 pt-6 px-6">Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="transaction in transactions.data" :key="transaction.id"
                            :class="transaction.type === 'buy' ? 'bg-green-200' : 'bg-red-200'">
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4">
                                    {{ transaction.id }}
                                </div>
                            </td>
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4">
                                    {{ transaction.account_number }}
                                </div>
                            </td>
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4">
                                    {{ transaction.type }}
                                </div>
                            </td>
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4">
                                    {{ transaction.crypto_name }}
                                </div>
                            </td>
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4">
                                    {{ Number(transaction.amount).toFixed(4) }}
                                </div>
                            </td>
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4">
                                    {{ formatMoney(Number(transaction.crypto_price), transaction.currency) }}
                                </div>
                            </td>
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4">
                                    {{ formatMoney(Number(transaction.total), transaction.currency) }}
                                </div>
                            </td>
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4">
                                    {{ formatDate(transaction.created_at) }}
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <Pagination :links="transactions.links" class="mt-6"/>

            </div>
        </div>
    </AppLayout>
</template>

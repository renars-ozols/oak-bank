<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link} from '@inertiajs/inertia-vue3';
import {format} from 'date-fns';

const props = defineProps({
    cryptos: Array,
    transactions: Array,
});

const formatPrice = (price, currency) => price.toLocaleString('en', {style: 'currency', currency: currency});

const formatDate = (date) => format(new Date(date), 'dd-MM-yyyy');

</script>

<template>
    <AppLayout title="Crypto-portfolio">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">#</th>
                            <th class="pb-4 pt-6 px-6">Name</th>
                            <th class="pb-4 pt-6 px-6">Amount</th>
                            <th class="pb-4 pt-6 px-6">Account</th>
                            <th class="pb-4 pt-6 px-6">Current value</th>
                            <th class="pb-4 pt-6 px-6">Average price</th>
                            <th class="pb-4 pt-6 px-6">Current price</th>
                            <th class="pb-4 pt-6 px-6"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(crypto, index) in cryptos" :key="crypto.id"
                            class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4 focus:text-indigo-500"
                                      :href="`/organizations/${crypto.id}/edit`">
                                    {{ index + 1 }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${crypto.id}/edit`"
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
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${crypto.id}/edit`"
                                      tabindex="-1">
                                    {{ Number(crypto.amount).toFixed(4) }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${crypto.id}/edit`"
                                      tabindex="-1">
                                    {{ crypto.account }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${crypto.id}/edit`"
                                      tabindex="-1">
                                    <!-- if percent change < 0 , then display red and add svg chevron down else color green and chevron up -->
                                    <span v-if="1 < 0" class="text-red-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                        {{ 0 }}%
                                    </span>
                                    <span v-else class="text-green-500 flex items-center">
                                        <!-- svg chevron up direction-->
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                          <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                                        </svg>
                                        +{{ 0 }}%
                                    </span>
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${crypto.id}/edit`"
                                      tabindex="-1">
                                    <!-- if percent change < 0 , then display red and add svg chevron down else color green and chevron up -->
                                    <span v-if="1 < 0" class="text-red-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                        {{ 0 }}%
                                    </span>
                                    <span v-else class="text-green-500 flex items-center">
                                        <!-- svg chevron up direction-->
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                          <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                                        </svg>
                                        +{{ 0 }}%
                                    </span>
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${crypto.id}/edit`"
                                      tabindex="-1">
                                    {{ formatPrice(crypto.current_price, crypto.currency) }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link :href="`/crypto/${crypto.id}`" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                    Trade
                                </Link>
                            </td>
                        </tr>
                        <tr v-if="cryptos.length === 0">
                            <td class="px-6 py-4 border-t" colspan="4">No organizations found.</td>
                        </tr>
                        </tbody>
                    </table>
                    <h1>Transactions:</h1>
                    <table class="w-full whitespace-nowrap">
                        <thead>
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">#</th>
                            <th class="pb-4 pt-6 px-6">Id</th>
                            <th class="pb-4 pt-6 px-6">Account</th>
                            <th class="pb-4 pt-6 px-6">Currency</th>
                            <th class="pb-4 pt-6 px-6">Type</th>
                            <th class="pb-4 pt-6 px-6">Name</th>
                            <th class="pb-4 pt-6 px-6">Amount</th>
                            <th class="pb-4 pt-6 px-6">Price per crypto</th>
                            <th class="pb-4 pt-6 px-6">Total</th>
                            <th class="pb-4 pt-6 px-6">Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(transaction, index) in transactions" :key="transaction.id"
                            :class="transaction.type === 'buy' ? 'bg-green-100 hover:bg-green-300 focus-within:bg-green-300' : 'bg-red-100 hover:bg-red-300 focus-within:bg-red-300'">
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4 focus:text-indigo-500"
                                      :href="`/organizations/${transaction.id}/edit`">
                                    {{ index + 1 }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${transaction.id}/edit`"
                                      tabindex="-1">
                                    {{ transaction.id }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${transaction.id}/edit`"
                                      tabindex="-1">
                                    {{ transaction.account_number }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${transaction.id}/edit`"
                                      tabindex="-1">
                                    {{ transaction.currency }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${transaction.id}/edit`"
                                      tabindex="-1">
                                    {{ transaction.type }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${transaction.id}/edit`"
                                      tabindex="-1">
                                    {{ transaction.crypto_name }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${transaction.id}/edit`"
                                      tabindex="-1">
                                    {{ Number(transaction.amount).toFixed(4) }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${transaction.id}/edit`"
                                      tabindex="-1">
                                    {{ formatPrice(Number(transaction.crypto_price), transaction.currency) }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${transaction.id}/edit`"
                                      tabindex="-1">
                                    {{ formatPrice(Number(transaction.total), transaction.currency) }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${transaction.id}/edit`"
                                      tabindex="-1">
                                    {{ formatDate(transaction.created_at) }}
                                </Link>
                            </td>
                        </tr>
                        <tr v-if="cryptos.length === 0">
                            <td class="px-6 py-4 border-t" colspan="4">No organizations found.</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Fix pagination -->
                <pagination class="mt-6" :links="cryptos"/>
                <!-- Fix pagination -->
            </div>
        </div>
    </AppLayout>
</template>

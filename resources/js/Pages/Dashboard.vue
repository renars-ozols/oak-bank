<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link} from '@inertiajs/inertia-vue3';
import {formatDistance} from 'date-fns';
import {formatMoney, formatDate} from "@/helpers";

// const transactions = [
//     {
//         'id': 1,
//         'from': 'LV33BANK4037802112316',
//         'from_name': 'Current Account',
//         'to': 'LV33BANK4037802112316',
//         'to_name': 'Jane Doe',
//         'currency': 'EUR',
//         'amount': 1000,
//     },
//     {
//         'id': 2,
//         'from': 'LV33BANK4037802112316',
//         'from_name': 'John Doe',
//         'to': 'LV33BANK4037802112316',
//         'to_name': 'Saving Account',
//         'currency': 'USD',
//         'amount': 1000,
//     },
// ];

const props = defineProps({
    accounts: Array,
    transactions: Array,
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
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">#</th>
                            <th class="pb-4 pt-6 px-6">Label</th>
                            <th class="pb-4 pt-6 px-6">Account number</th>
                            <th class="pb-4 pt-6 px-6">Currency</th>
                            <th class="pb-4 pt-6 px-6">Balance</th>
                            <th class="pb-4 pt-6 px-6"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(account, index) in accounts" :key="account.id"
                            class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4 focus:text-indigo-500"
                                      :href="`/organizations/${account.id}/edit`">
                                    {{ index + 1 }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${account.id}/edit`"
                                      tabindex="-1">
                                    {{ account.name }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${account.id}/edit`"
                                      tabindex="-1">
                                    {{ account.number }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${account.id}/edit`"
                                      tabindex="-1">
                                    {{ account.currency }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${account.id}/edit`"
                                      tabindex="-1">
                                    {{ formatMoney(Number(account.balance), account.currency) }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link :href="`/crypto/${account.id}`" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                    Action
                                </Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">#</th>
                            <th class="pb-4 pt-6 px-6">Id</th>
                            <th class="pb-4 pt-6 px-6">From</th>
                            <th class="pb-4 pt-6 px-6"></th>
                            <th class="pb-4 pt-6 px-6">To</th>
                            <th class="pb-4 pt-6 px-6"></th>
                            <th class="pb-4 pt-6 px-6">Currency</th>
                            <th class="pb-4 pt-6 px-6">Amount</th>
                            <th class="pb-4 pt-6 px-6">Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(transaction, index) in transactions" :key="transaction.id"
                            class="hover:bg-gray-100 focus-within:bg-gray-100"
                            :class="transaction.recipient_account.user.id === $page.props.user.id ? 'bg-green-100 hover:bg-green-300 focus-within:bg-green-300' : 'bg-red-100 hover:bg-red-300 focus-within:bg-red-300'">
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
                                    {{ transaction.sender_account.user.name }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${transaction.id}/edit`"
                                      tabindex="-1">
                                    {{ transaction.sender_account.number }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${transaction.id}/edit`"
                                      tabindex="-1">
                                    {{ transaction.recipient_account.user.name }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${transaction.id}/edit`"
                                      tabindex="-1">
                                    {{ transaction.recipient_account.number }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${transaction.id}/edit`"
                                      tabindex="-1">
                                    {{ transaction.recipient_account.currency }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${transaction.id}/edit`"
                                      tabindex="-1">
                                    <span v-if="transaction.recipient_account.user.id === $page.props.user.id" class="mr-1">+</span>
                                    <span v-else class="mr-1">-</span>
                                    {{ formatMoney(transaction.amount, transaction.recipient_account.currency) }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="`/organizations/${transaction.id}/edit`"
                                      tabindex="-1">
                                    {{ formatDate(transaction.created_at) }}
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

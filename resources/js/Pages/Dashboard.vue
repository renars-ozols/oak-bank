<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from "@/Components/TextInput.vue";
import {formatMoney, formatDate} from "@/helpers";
import {reactive, watch} from "vue";
import {Inertia} from "@inertiajs/inertia";
import pickBy from "lodash/pickBy";
import throttle from "lodash/throttle";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    accounts: Array,
    transactions: Object,
});

const form = reactive({
    search_name: '',
    search_account: '',
    start_date: '',
    end_date: '',
});

const resetFilters = () => {
    form.search_name = '';
    form.search_account = '';
    form.start_date = '';
    form.end_date = '';
};

const throttled = throttle((form) => {
    Inertia.get(route('dashboard'), pickBy(form), {
        preserveState: true,
        replace: true,
    });
}, 500);

watch(form, (form) => {
    throttled(form);
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
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(account, index) in accounts" :key="account.id">
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4 focus:text-indigo-500">
                                    {{ index + 1 }}
                                </div>
                            </td>
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4">
                                    {{ account.name }}
                                </div>
                            </td>
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4">
                                    {{ account.number }}
                                </div>
                            </td>
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4">
                                    {{ account.currency }}
                                </div>
                            </td>
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4">
                                    {{ formatMoney(Number(account.balance), account.currency) }}
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex align-middle">

                    <TextInput
                        id="search"
                        v-model="form.search_account"
                        type="text"
                        class="mt-1 ml-2 block"
                        placeholder="Search by account..."
                    />

                    <TextInput
                        id="search"
                        v-model="form.search_name"
                        type="text"
                        class="mt-1 ml-2 block"
                        placeholder="Search by name..."
                    />

                    <TextInput
                        id="start_date"
                        v-model="form.start_date"
                        type="date"
                        class="mt-1 ml-2 block"
                        placeholder="Start date..."
                    />

                    <TextInput
                        id="end_date"
                        v-model="form.end_date"
                        type="date"
                        class="mt-1 ml-2 block"
                        placeholder="End date..."
                    />

                    <button type="button" @click="resetFilters" class="ml-2 self-center text-gray-500">Reset</button>
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
                            <th class="pb-4 pt-6 px-6">To</th>
                            <th class="pb-4 pt-6 px-6">Amount</th>
                            <th class="pb-4 pt-6 px-6">Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(transaction, index) in transactions.data" :key="transaction.id"
                            :class="transaction.recipient_account.user.id === $page.props.user.id ? 'bg-green-200' : 'bg-red-200'">
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4">
                                    {{ index + 1 }}
                                </div>
                            </td>
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4">
                                    {{ transaction.id }}
                                </div>
                            </td>
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4">
                                    <span
                                        v-if="transaction.sender_account.user.id === $page.props.user.id">{{
                                            transaction.sender_account.name
                                        }}</span>
                                    <span v-else>{{ transaction.sender_account.user.name }}</span>
                                    <span class="ml-1">({{ transaction.sender_account.number }})</span>
                                </div>
                            </td>
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4">
                                    <span
                                        v-if="transaction.recipient_account.user.id === $page.props.user.id">{{
                                            transaction.recipient_account.name
                                        }}</span>
                                    <span v-else>{{ transaction.recipient_account.user.name }}</span>
                                    <span class="ml-1">({{ transaction.recipient_account.number }})</span>
                                </div>
                            </td>
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4">
                                    <span class="mr-1">({{ transaction.recipient_account.currency }})</span>
                                    <span v-if="transaction.recipient_account.user.id === $page.props.user.id"
                                          class="mr-1">+</span>
                                    <span v-else class="mr-1">-</span>
                                    {{ formatMoney(transaction.amount, transaction.recipient_account.currency) }}
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
                <Pagination class="mt-6" :links="transactions.links"/>
            </div>
        </div>
    </AppLayout>
</template>

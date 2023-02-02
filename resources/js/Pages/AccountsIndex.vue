<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {formatMoney, formatDate} from "@/helpers";
import {reactive, watch} from "vue";
import {Inertia} from "@inertiajs/inertia";
import pickBy from "lodash/pickBy";
import throttle from "lodash/throttle";
import Pagination from "@/Components/Pagination.vue";
import TransactionFilter from "@/Components/TransactionFilter.vue";
import {Link} from "@inertiajs/inertia-vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

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
    Inertia.get(route('accounts.index'), pickBy(form), {
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
    <AppLayout title="Overview">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Accounts
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg overflow-x-auto">
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
                            <td class="border-t">
                                <Link :href="route('accounts.edit', account)" class="flex items-center px-6 py-4">
                                    <PrimaryButton>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                        </svg>
                                        Edit
                                    </PrimaryButton>
                                </Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <TransactionFilter
                    :endDate="form.end_date"
                    :searchOne="form.search_account"
                    :searchTwo="form.search_name"
                    :startDate="form.start_date"
                    searchOnePlaceholder="Search by account..."
                    searchTwoPlaceholder="Search by name..."
                    @reset="resetFilters"
                    @update:searchOne="form.search_account = $event"
                    @update:searchTwo="form.search_name = $event"
                    @update:startDate="form.start_date = $event"
                    @update:endDate="form.end_date = $event"
                />
            </div>

            <div class="mt-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">Id</th>
                            <th class="pb-4 pt-6 px-6">From</th>
                            <th class="pb-4 pt-6 px-6">To</th>
                            <th class="pb-4 pt-6 px-6">Amount</th>
                            <th class="pb-4 pt-6 px-6">Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="transaction in transactions.data" :key="transaction.id"
                            :class="transaction.recipient_account.user.id === $page.props.user.id ? 'bg-green-200' : 'bg-red-200'">
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

                <Pagination :links="transactions.links" class="mt-6"/>
            </div>

        </div>
    </AppLayout>
</template>

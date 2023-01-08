<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Inertia} from "@inertiajs/inertia";
import {useForm} from "@inertiajs/inertia-vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import SelectInput from "@/Components/SelectInput.vue";
import NumericInput from "@/Components/NumericInput.vue";
import BuyButton from "@/Components/BuyButton.vue";
import SellButton from "@/Components/SellButton.vue";

const props = defineProps({
    crypto: Object,
    accounts: Array,
});

const buyForm = useForm({
    account: '',
    amount: null,
});

const sellForm = useForm({
    account: '',
    amount: null,
});

const submitBuyForm = () => {
    buyForm.transform(data => ({
        ...data,
    })).post(route('crypto.buy', props.crypto.id), {
        onFinish: () => buyForm.reset('name', 'currency'),
    });
};

const submitSellForm = () => {
    form.transform(data => ({
        ...data,
    })).post(route('crypto.sell'), {
        onFinish: () => form.reset('name', 'currency'),
    });
};

const formatPrice = (price, currency) => price.toLocaleString('en', {style: 'currency', currency: currency});

const onAccountChange = (event) => {
    //split the value of the select into an array
    const currency = event.target.options[event.target.selectedIndex].text.split(' ')[0];
    //const currency = props.crypto.currency;
    //set the currency of the form
    Inertia.get(route('crypto.show', {id: props.crypto.id}), {
            currency: currency,
    }, {
        preserveState: true,
        preserveScroll: true,
        only: ['crypto'],
    });
};
</script>

<template>
    <AppLayout v-bind:title="crypto.name">

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex items-center flex-col">
                    <div class="flex items-center py-8">
                        <img v-bind:src="crypto.logo" alt={{crypto.name}} width="60" class="rounded-full">
                        <div class="flex flex-col-reverse items-end">
                            <span class="ml-2 font-bold text-3xl">{{ crypto.name }}</span>
                            <span class="ml-2 font-semibold bg-gray-300 text-gray-800 rounded-full px-3 py-1 text-xs">
                                {{ crypto.symbol }}
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="flex font-bold text-2xl mb-4">
                            <span class="mr-2">Price:</span>
                            <span class="">{{ formatPrice(crypto.price, crypto.currency) }}</span>
                        </div>
                        <div>
                            <div class="flex mb-2">
                                <span class="font-bold text-xl mr-4">Percent change 1h %:</span>
                                <span v-if="crypto.percentChange1h < 0" class="text-red-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
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
                            </div>
                            <div class="flex mb-2">
                                <span class="font-bold text-xl mr-4">Percent change 24h %:</span>
                                <span v-if="crypto.percentChange24h < 0" class="text-red-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                        {{ crypto.percentChange24h.toFixed(2) }}%
                                </span>
                                <span v-else class="text-green-500 flex items-center">
                                    <!-- svg chevron up direction-->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                      <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                                    </svg>
                                    +{{ crypto.percentChange24h.toFixed(2) }}%
                                </span>
                            </div>
                            <div class="flex mb-2">
                                <span class="font-bold text-xl mr-4">Percent change 7d %:</span>
                                <span v-if="crypto.percentChange7d < 0" class="text-red-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                        {{ crypto.percentChange7d.toFixed(2) }}%
                                </span>
                                <span v-else class="text-green-500 flex items-center">
                                    <!-- svg chevron up direction-->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                      <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                                    </svg>
                                    +{{ crypto.percentChange7d.toFixed(2) }}%
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex">
                        <form @submit.prevent="submitBuyForm" class="w-1/2 mx-auto py-8 mr-2">
                            <div>
                                <InputLabel for="account" value="Select account" />
                                <SelectInput
                                    id="account"
                                    v-model="buyForm.account"
                                    :options="accounts"
                                    valueProp="number"
                                    @change="onAccountChange($event)"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError class="mt-2" :message="buyForm.errors.account" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="amount" value="Amount" />
                                <NumericInput
                                    id="amount"
                                    v-model="buyForm.amount"
                                    type="number"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError class="mt-2" :message="buyForm.errors.amount" />
                            </div>

                            <div class="mt-4">
                                <BuyButton :class="{ 'opacity-25': buyForm.processing }" :disabled="buyForm.processing">
                                    Buy
                                </BuyButton>
                            </div>
                        </form>
                        <form @submit.prevent="submitSellForm" class="w-1/2 mx-auto py-8 ml-2">
                            <div>
                                <InputLabel for="account" value="Select account" />
                                <SelectInput
                                    id="account"
                                    v-model="sellForm.account"
                                    :options="accounts"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError class="mt-2" :message="sellForm.errors.account" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="amount" value="Amount" />
                                <NumericInput
                                    id="amount"
                                    v-model="sellForm.amount"
                                    type="number"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError class="mt-2" :message="sellForm.errors.amount" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <SellButton :class="{ 'opacity-25': sellForm.processing }" :disabled="sellForm.processing">
                                    Sell
                                </SellButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

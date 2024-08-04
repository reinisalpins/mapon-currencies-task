<script setup>
import Filters from '../components/filters/Filters.vue';
import CurrenciesWithRates from '../components/currencies-with-rates/CurrenciesWithRates.vue';
import {useCurrenciesStore} from "../store/useCurrenciesStore.js";

const currenciesStore = useCurrenciesStore();
</script>

<template>
    <filters></filters>
    <currencies-with-rates></currencies-with-rates>
    <div class="error-message" v-if="currenciesStore.currenciesWithRates.length === 0">No currencies were found</div>
</template>

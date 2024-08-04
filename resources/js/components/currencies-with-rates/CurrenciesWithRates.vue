<script setup>
import CurrencyWithExchangeRatesCard from "./CurrencyWithExchangeRatesCard.vue";
import {useCurrenciesStore} from "../../store/useCurrenciesStore.js";
import {computed, watch} from "vue";
import {useFilterStore} from "../../store/useFilterStore.js";

const currenciesStore = useCurrenciesStore();
const filterStore = useFilterStore();

const currencies = computed(() => currenciesStore.currenciesWithRates)

const selectedCurrencyCodes = computed(() => filterStore.selectedCodes);
const selectedDates = computed(() => filterStore.selectedDates);

watch([selectedCurrencyCodes, selectedDates], () => {
    const params = {
        'dates': selectedDates.value,
        'currencies': selectedCurrencyCodes.value
    }

    currenciesStore.fetchCurrenciesWithRates(params);
}, {deep: true});
</script>

<template>
    <div class="rates-display-container">
        <div v-for="currency in currencies">
            <currency-with-exchange-rates-card
                :currency-code="currency.code"
                :exchange-rates="currency.euroExchangeRates"
            />
        </div>
    </div>
</template>

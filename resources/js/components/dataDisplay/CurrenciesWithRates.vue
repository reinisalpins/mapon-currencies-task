<script setup>
import CurrencyWithExchangeRatesCard from "./CurrencyWithExchangeRatesCard.vue";

const props = defineProps({
    currencies: Array
})
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

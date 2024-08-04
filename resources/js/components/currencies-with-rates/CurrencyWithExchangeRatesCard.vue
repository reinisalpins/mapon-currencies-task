<script setup>
import {defineProps} from 'vue';

const props = defineProps({
    currencyCode: String,
    exchangeRates: Array,
});
</script>

<template>
    <div class="currency-card">
        <div class="currency-info">
            <span>Currency Code: <b>{{ currencyCode }}</b></span>
        </div>
        <div class="exchange-rates" v-if="exchangeRates.length > 0">
            <div style="overflow-x: auto;">
                <table>
                    <tr>
                        <th>Relevance date</th>
                        <th>Rate</th>
                    </tr>
                    <tr v-for="rate in exchangeRates">
                        <td>{{ rate.rateRelevanceDate }}</td>
                        <td>{{ rate.rate }}</td>
                    </tr>

                </table>
            </div>
        </div>
        <div v-else class="exchange-rates">
            There is no data available for requested date for this currency
        </div>
    </div>
</template>

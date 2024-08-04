<script setup>
import {onMounted, ref} from 'vue';
import {useRoute, useRouter} from 'vue-router';
import axios from 'axios';
import TableFilters from '../components/filters/TableFilters.vue';
import CurrenciesWithRates from '../components/dataDisplay/CurrenciesWithRates.vue';

const currencies = ref([]);
const route = useRoute();
const router = useRouter();

const queryParams = {
    currencies: route.query['currencies'] || null,
    dates: route.query['dates'] || null,
};

const fetchCurrencies = async () => {
    try {
        const params = {};
        if (queryParams.currencies) params['currencies'] = queryParams.currencies;
        if (queryParams.dates) params['dates'] = queryParams.dates;

        const response = await axios.get('/api/currencies', {params});
        currencies.value = response.data.data;
    } catch (error) {
        console.error('Error fetching currencies:', error);
    }
};

onMounted(() => {
    fetchCurrencies();
});

const handleCurrenciesStateChanged = (selectedCurrencies) => {
    queryParams.currencies = selectedCurrencies;
    const filteredQueryParams = Object.fromEntries(
        Object.entries(queryParams).filter(([_, value]) => value !== null && value !== '')
    );

    router.replace({query: filteredQueryParams});

    fetchCurrencies();
};

const handleDatesStateChanged = (selectedDates) => {
    queryParams.dates = selectedDates;
    const filteredQueryParams = Object.fromEntries(
        Object.entries(queryParams).filter(([_, value]) => value !== null && value !== '')
    );

    router.replace({query: filteredQueryParams});

    fetchCurrencies();
}
</script>

<template>
    <table-filters @currencies-state-changed="handleCurrenciesStateChanged"
                   @dates-state-changed="handleDatesStateChanged"></table-filters>
    <currencies-with-rates :currencies="currencies" v-if="currencies.length > 0"></currencies-with-rates>
    <div v-else class="error-message">No currencies were found</div>
</template>

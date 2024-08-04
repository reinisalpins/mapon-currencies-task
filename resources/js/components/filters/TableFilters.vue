<script setup>
import {onMounted, ref, watch} from 'vue';
import {useRoute} from 'vue-router';
import axios from 'axios';

const selectedCurrencies = ref([]);
const currencyCodes = ref([]);
const availableDates = ref([]);

const selectedDates = ref([]);

const fetchCurrencyCodes = async () => {
    try {
        const response = await axios.get('/api/currencies/codes');
        currencyCodes.value = response.data.data;
    } catch (error) {
        console.error('Error fetching currencies:', error);
    }
};

const toggleCurrency = (code) => {
    if (selectedCurrencies.value.includes(code)) {
        selectedCurrencies.value = selectedCurrencies.value.filter(c => c !== code);
    } else {
        selectedCurrencies.value = [...selectedCurrencies.value, code];
    }
};

const toggleDate = (date) => {
    if (selectedDates.value.includes(date)) {
        selectedDates.value = selectedDates.value.filter(d => d !== date);
    } else {
        selectedDates.value = [...selectedDates.value, date];
    }
};

const fetchAvailableDates = async () => {
    try {
        const response = await axios.get('/api/exchange-rates/available-dates');
        availableDates.value = response.data.data;
    } catch (error) {
        console.error('Error fetching available dates:', error);
    }
}

const parseQueryParams = () => {
    const route = useRoute();
    const currencies = route.query.currencies;
    const dates = route.query.dates;

    if (currencies) {
        selectedCurrencies.value = Array.isArray(currencies) ? currencies : [currencies];
    }

    if (dates) {
        selectedDates.value = Array.isArray(dates) ? dates : [dates];
    }
};

onMounted(() => {
    fetchCurrencyCodes();
    fetchAvailableDates();
    parseQueryParams();
});

const emit = defineEmits(['currenciesStateChanged', 'datesStateChanged']);

watch(selectedCurrencies, () => {
    emit('currenciesStateChanged', selectedCurrencies.value);
});

watch(selectedDates, () => {
    emit('datesStateChanged', selectedDates.value);
})
</script>

<template>
    <div class="currencies-form">
        <label>Currencies:</label>
        <div class="selectable-cards">
            <div v-for="currency in currencyCodes" :key="currency.code" class="selectable-card"
                 :class="{ selected: selectedCurrencies.includes(currency.code) }"
                 @click="toggleCurrency(currency.code)"
            >
                {{ currency.code }}
            </div>
        </div>
        <button class="primary-button" @click="selectedCurrencies = []">Clear selected</button>
    </div>

    <div class="dates-form">
        <label>Available dates:</label>
        <div class="selectable-cards">
            <div v-for="(date, key) in availableDates" :key="key" class="selectable-card"
                 :class="{ selected: selectedDates.includes(date.date) }"
                 @click="toggleDate(date.date)"
            >
                {{ date.date }}
            </div>
        </div>
        <button class="primary-button" @click="selectedDates = []">Clear selected</button>
    </div>
</template>

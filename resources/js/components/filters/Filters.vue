<script setup>
import {computed, onMounted} from 'vue';
import {useFilterStore} from "../../store/useFilterStore.js";

const filterStore = useFilterStore();

onMounted(async () => {
    await filterStore.fetchAvailableDates();
    await filterStore.fetchCurrencyCodes();
});

const currencyCodes = computed(() => filterStore.currencyCodes);
const availableDates = computed(() => filterStore.availableDates);
</script>

<template>
    <div class="currencies-form">
        <label>Currencies:</label>
        <div class="selectable-cards">
            <div v-for="currency in currencyCodes" :key="currency.code" class="selectable-card"
                 :class="{ selected: filterStore.selectedCodes.includes(currency.code) }"
                 @click="filterStore.toggleCurrency(currency.code)"
            >
                {{ currency.code }}
            </div>
        </div>
        <button class="primary-button" @click="filterStore.selectedCodes = []">Clear selected</button>
    </div>

    <div class="dates-form">
        <label>Available dates (select none for today):</label>
        <div class="selectable-cards">
            <div v-for="(date, key) in availableDates" :key="key" class="selectable-card"
                 :class="{ selected: filterStore.selectedDates.includes(date.date) }"
                 @click="filterStore.toggleSelectedDate(date.date)"
            >
                {{ date.date }}
            </div>
        </div>
        <button class="primary-button" @click="filterStore.selectedDates = []">Clear selected</button>
    </div>
</template>

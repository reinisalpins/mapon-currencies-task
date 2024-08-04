import {defineStore} from "pinia";

export const useFilterStore = defineStore('filters', {
    state: () => ({
        availableDates: [],
        currencyCodes: [],
        selectedDates: [],
        selectedCodes: [],
        latestAvailableDate: null
    }),
    actions: {
        async fetchAvailableDates() {
            try {
                const response = await axios.get('/api/exchange-rates/available-dates');
                this.availableDates = response.data.data;

                if (this.availableDates.length > 0) {
                    this.selectedDates.push(response.data.data[0].date);
                }
            } catch (error) {
                console.error('Error fetching available dates:', error);
            }
        },
        async fetchCurrencyCodes() {
            try {
                const response = await axios.get('/api/currencies/codes');
                this.currencyCodes = response.data.data;
            } catch (error) {
                console.error('Error fetching currency codes:', error);
            }
        },
        toggleCurrency(currencyCode) {
            const index = this.selectedCodes.indexOf(currencyCode);

            if (index > -1) {
                this.selectedCodes.splice(index, 1);
            } else {
                this.selectedCodes.push(currencyCode);
            }
        },
        toggleSelectedDate(selectedDate) {
            const index = this.selectedDates.indexOf(selectedDate);

            if (index > -1) {
                this.selectedDates.splice(index, 1);
            } else {
                this.selectedDates.push(selectedDate);
            }
        },
    }
})

import {defineStore} from "pinia";

export const useCurrenciesStore = defineStore('displayed-data', {
    state: () => ({
        currenciesWithRates: []
    }),
    actions: {
        async fetchCurrenciesWithRates(params = null) {
            try {
                const response = await axios.get('api/currencies', {params});
                this.currenciesWithRates = response.data.data;
            } catch (error) {
                console.error('Error fetching currency with rates:', error);
            }
        }
    }
})

import axiosClient from '@/utils/axiosClient';

export default {
    state: {
        client_visits: [],
        sales: [],
        trainer_visits: [],
    },
    getters: {
        client_visits: s => s.client_visits,
        sales: s => s.sales,
        trainer_visits: s => s.trainer_visits,
        trainer_sales: s => s.trainer_sales,
    },
    mutations: {
        setReports ( state, reports ) {
            console.log(reports);
            state.client_visits = reports.client_visits;
            state.sales = reports.sales;
            state.trainer_visits = reports.trainer_visits;
            state.trainer_sales = reports.trainer_sales;
        }
    },
    actions: {
        async getReports ({ commit }, payload) {
            const params = new URLSearchParams(payload);
            const { data } = await axiosClient.get(`economy?${params}`);
            commit('setReports', data.reports);
        }
    }
}

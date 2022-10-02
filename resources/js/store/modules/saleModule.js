import axiosClient from '@/utils/axiosClient';

export default {
    state: {
        payment_types: [],
    },
    getters: {
        payment_types: state => state.payment_types,
    },
    mutations: {
        setPaymentTypes (state, types) {
            state.payment_types = types;
        },
    },
    actions: {
        async getPaymentTypes ({ commit }) {
            const { data: { data } } = await axiosClient.get(`/sales/payment-types`);
            commit('setPaymentTypes', data);
        },
        async createSale ({ commit }, payload) {
            const { data: { data } } = await axiosClient.post('/sales', payload);
            commit('setClient', data);
        },
    }
}

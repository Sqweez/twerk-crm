import axiosClient from '@/utils/axiosClient';

export default {
    state: {
        subscriptions: [],
        subscription_types: [],
    },
    getters: {
        subscriptions: state => state.subscriptions,
        subscription_types: state => state.subscription_types,
    },
    mutations: {
        setSubscriptionTypes (state, types) {
            state.subscription_types = types;
        },
        setSubscriptions (state, payload) {
            state.subscriptions = payload;
        },
        deleteSubscription (state, id) {
            state.subscriptions = state.subscriptions.filter(s => s.id !== id);
        }
    },
    actions: {
        async getSubscriptions ({ commit }) {
            const { data: { data } } = await axiosClient.get('/subscriptions');
            commit('setSubscriptions', data);
        },
        async getSubscriptionTypes ({ commit }) {
            const { data: { data } } = await axiosClient.get('/subscriptions/types');
            commit('setSubscriptionTypes', data);
        },
        async deleteSubscription ({ commit }, id) {
            await axiosClient.delete(`/subscriptions/${id}`);
            commit('deleteSubscription', id);
        }
    }
}

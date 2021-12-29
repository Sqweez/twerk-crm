import axiosClient from "../../utils/axiosClient";
import axios from "axios";

export default {
    state: {
        clients: [],
        nearlyClients: [],
        outdatedClients: [],
        todayClients: [],
    },
    getters: {
        clients: s => s.clients,
        client: s => id => s.clients.find(c => c.id === id),
        nearlyClients: s => s.nearlyClients,
        outdatedClients: s => s.outdatedClients,
        todayClients: s => s.todayClients,
    },
    mutations: {
        setClients(state, p) {
            state.clients = p;
        },
        createClient(state, p) {
            state.clients.push(p);
        },
        editClient(state, p) {
            state.clients = state.clients.map(c => {
                if (c.id == p.id) {
                    c = {...p};
                }
                return c;
            })
        },
        deleteClient(state, id) {
            state.clients = state.clients.filter(c => c.id !== id);
        },
        setNearlyClients(state, p) {
            state.nearlyClients = p;
        },
        setOutdatedClients(state, p) {
            state.outdatedClients = p;
        },
        setTodayClients(s, p) {
            s.todayClients = p;
        }
    },
    actions: {
        async getClients({commit}) {
            commit('enableLoading');
            const r = await axiosClient.get('/clients');
            commit('setClients', r.data.data);
            commit('disableLoading');
        },
        async createClient({commit}, p) {
            commit('enableLoading');
            const r = await axiosClient.post('/clients', p);
            commit('createClient', r.data.data);
            commit('disableLoading');
        },
        async editClient({commit}, p) {
            commit('enableLoading');
            const r = await axiosClient.patch(`/clients/${p.id}`, p);
            commit('editClient', r.data.data);
            commit('disableLoading');
        },
        async deleteClient({commit}, id) {
            commit('enableLoading');
            await axiosClient.delete(`/clients/${id}`);
            commit('deleteClient', id);
            commit('disableLoading');
        },
        async getNearlyClients({ commit }) {
            const { data } = await axiosClient.get('/clients/nearly');
            commit('setNearlyClients', data.data);
        },
        async getOutdatedClients({ commit }) {
            const { data } = await axiosClient.get('/clients/outdated');
            commit('setOutdatedClients', data.data);
        },
        async getTodayClients({ commit }) {
            const { data } = await axiosClient.get('/clients/today');
            commit('setTodayClients', data.data);
        }
    }
}

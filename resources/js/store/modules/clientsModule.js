import axiosClient from "../../utils/axiosClient";
import axios from "axios";

export default {
    state: {
        clients: [],
        client: null,
    },
    getters: {
        clients: s => s.clients,
        client: s => id => s.clients.find(c => c.id === id),
        nearlyClients: s => s.nearlyClients,
        outdatedClients: s => s.outdatedClients,
        todayClients: s => s.todayClients,
        singleClient: s => s.client,
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
        },
        setClient (state, client) {
            state.client = client;
        }
    },
    actions: {
        async getClients({commit}) {
            const r = await axiosClient.get('/clients');
            commit('setClients', r.data.data);
        },
        async createClient({commit}, payload) {
            try {
                this.$loading.enable();
                const { data: { data } } = await axiosClient.post('/clients', payload);
                commit('createClient', data);
            } catch (e) {
                throw e;
            }
            finally {
                this.$loading.disable();
            }
        },
        async editClient({commit}, { payload, id }) {
            try {
                this.$loading.enable();
                const { data: { data } } = await axiosClient.post(`/clients/${id}?_method=PATCH`, payload);
                commit('editClient', data);
            } catch (e) {
                throw e;
            }
            finally {
                this.$loading.disable();
            }
        },
        async deleteClient({commit}, id) {
            await axiosClient.delete(`/clients/${id}`);
            commit('deleteClient', id);
        },
        async getClient ({ commit }, id) {
            const { data: { data } } = await axiosClient.get(`/clients/${id}`);
            commit('setClient', data);
        }
    }
}

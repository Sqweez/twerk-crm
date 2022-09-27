import axiosClient from "../../utils/axiosClient";

export default {
    state: {
        users: [],
        roles: [],
    },
    getters: {
        users: state => state.users,
        user: state => id => state.users.find(u => u.id === id),
        roles: state => state.roles,
        trainers: state => state.users.filter(u => u.is_trainer),
    },
    mutations: {
        setUsers(state, payload) {
            state.users = payload;
        },
        createUser(state, payload) {
            state.users.push(payload);
        },
        editUser(state, payload) {
            state.users = state.users.map(u => {
                if (u.id === payload.id) {
                    u = {...payload};
                }
                return u;
            })
        },
        deleteUser(state, id) {
            state.users = state.users.filter(u => u.id !== id);
        },
        setRoles (state, payload) {
            state.roles = payload;
        }
    },
    actions: {
        async getRoles ({ commit }) {
            const { data: { data } } = await axiosClient.get('/users/roles');
            commit('setRoles', data);
        },
        async getUsers ({ commit }) {
            const { data: { data } } = await axiosClient.get('/users');
            commit('setUsers', data);
        },
        async createUser ({ commit }, payload) {
            const { data } = await axiosClient.post('/users', payload);
            commit('createUser', data.data);
        },
        async editUser ({ commit }, payload) {
            const { data } = await axiosClient.patch(`/users/${payload.id}`, payload);
            commit('editUser', data.data);
        },
        async deleteUser ({ commit }, id) {
            await axiosClient.delete(`/users/${id}`);
            commit('deleteUser', id);
        }
    }
}

import axiosClient from "../../utils/axiosClient";

export default {
    state: {
        users: [],
    },
    getters: {
        users: s => s.users,
        user: s => id => s.users.find(u => u.id === id)
    },
    mutations: {
        setUsers(s, p) {
            s.users = p;
        },
        createUser(s, p) {
            s.users.push(p);
        },
        editUser(s, p) {
            s.users = s.users.map(u => {
                if (u.id === p.id) {
                    u = {...p};
                }
                return u;
            })
        },
        deleteUser(s, id) {
            s.users = s.users.filter(u => u.id !== id);
        }
    },
    actions: {
        async getUsers({commit}) {
            const { data } = await axiosClient.get('/users');
            commit('setUsers', data.data);
        },
        async createUser({commit}, p) {
            const { data } = await axiosClient.post('/users', p);
            commit('createUser', data);
        },
        async editUser({commit}, p) {
            const { data } = await axiosClient.patch(`/users/${p.id}`, p);
            commit('editUser', data);
        },
        async deleteUser({commit}, id) {
            await axiosClient.delete(`/users/${id}`);
            commit('deleteUser', id);
        }
    }
}

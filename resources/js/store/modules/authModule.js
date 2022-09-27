import axiosClient from "../../utils/axiosClient";

export default {
    state: {
        user: null,
        is_auth_checked: false,
        token: null,
    },
    getters: {
        LOGIN_CHECKED: s => s.is_auth_checked,
        USER: s => s.user,
        LOGGED_IN: s => !!s.user
    },
    mutations: {
        setToken(state, token) {
            if (token) {
                localStorage.setItem('token', token);
            } else {
                localStorage.removeItem('token');
            }
            state.token = token;
        },
        setAuthChecked(state) {
            state.is_auth_checked = true;
        },
        setUser(state, user) {
            state.user = user;
        }
    },
    actions: {
        async LOGOUT() {
            localStorage.removeItem('token');
        },
        async AUTH({commit, dispatch}) {
            try {
                const { data: { data } } = await axiosClient.get('/me');
                commit('setUser', data);
                dispatch('INIT');
            } catch (e) {
                commit('setUser', null);
                commit('setToken', null);
            } finally {
                commit('setAuthChecked');
            }
        },
        async LOGIN({commit, dispatch}, payload) {
            try {
                const response = await axiosClient.post('/login', payload);
                const { data } = response.data;
                axiosClient.defaults.headers = {'Authorization': 'Bearer ' + data.token};
                commit('setToken', data.token);
                window.location.reload();
            } catch (e) {
                throw e;
            }
        }
    }
}

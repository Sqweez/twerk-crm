import axiosClient from "../../utils/axiosClient";

export default {
    state: {
        is_loading: false,
        user: null,
        is_auth_checked: false,
        token: null,
    },
    getters: {
        IS_LOADING: s => s.is_loading,
        LOGIN_CHECKED: s => s.is_auth_checked,
        USER: s => s.user,
        LOGGED_IN: s => !!s.user
    },
    mutations: {
        setToken(state, token) {
            localStorage.setItem('token', token);
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
        async AUTH({commit}) {
            commit('enableLoading');
            try {
                const response = await axiosClient.get('/me');
                commit('setUser', response.data);
                commit('setAuthChecked', true);
            } catch (e) {
                console.log(e);
            } finally {
                commit('setAuthChecked');
                commit('disableLoading');
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

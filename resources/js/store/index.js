import Vue from 'vue'
import Vuex, {Store} from "vuex"
Vue.use(Vuex);
import axiosClient from "../utils/axiosClient";
import clientsModule from "./modules/clientsModule";
import usersModule from "./modules/usersModule";
import authModule from "./modules/authModule";

const store = new Store({
    getters: {
        navigations: s =>  ([
            {
                title: 'Главная страница',
                url: '/',
                icon: 'dashboard',
            },
            {
                title: 'Клиенты',
                url: '/clients',
                icon: 'person'
            },
            {
                title: 'Админы',
                url: '/admins',
                icon: 'person'
            },
        ]),
    },
    mutations: {
        enableLoading(state) {
            state.is_loading = true;
        },
        disableLoading(state) {
            state.is_loading = false;
        },
    },
    actions: {
        async INIT({commit, dispatch}) {
        },
    },
    modules: {
        authModule,
        clientsModule,
        usersModule
    },
});


export default store;

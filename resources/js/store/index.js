import Vue from 'vue'
import Vuex, {Store} from "vuex"
Vue.use(Vuex);
import clientsModule from "./modules/clientsModule";
import usersModule from "./modules/usersModule";
import authModule from "./modules/authModule";
import subscriptionModule from "./modules/subscriptionModule";
import saleModule from "./modules/saleModule";
import reportsModule from "./modules/reportsModule";
import VuexPlugins from '@/store/plugins/vuexPlugins';

const store = new Store({
    state: {
        is_loading: false,
    },
    getters: {
        IS_LOADING: s => s.is_loading,
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
                title: 'Пользователи',
                url: '/users',
                icon: 'person'
            },
            {
                title: 'Абонементы',
                url: '/subscriptions',
                icon: 'list'
            },
            {
                title: 'Статистика',
                url: '/economy',
                icon: 'list'
            },
           /* {
                title: 'Настройки',
                url: '/settings',
                icon: 'dashboard'
            },*/
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
        async INIT ({ dispatch }) {
            await Promise.all([
                dispatch('getSubscriptionTypes'),
                dispatch('getRoles'),
                dispatch('getPaymentTypes')
            ]);
        }
    },
    modules: {
        authModule,
        clientsModule,
        usersModule,
        subscriptionModule,
        saleModule,
        reportsModule
    },
    plugins: [VuexPlugins]
});


export default store;

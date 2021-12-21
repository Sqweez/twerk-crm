import Vue from 'vue'
import VueRouter from "vue-router";
import routes from "./routes";
import store from "@/store";
import ToastService from "@/utils/toastService";

const $toast = new ToastService();

Vue.use(VueRouter);

const Router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes,
    scrollBehavior(to, from, savePos) {
        return {x: 0, y: 0};
    }
});

Router.beforeEach(async (to, from, next) => {
    if (!store.getters.LOGIN_CHECKED) {
        await store.dispatch('AUTH');
    }

    const IS_GUEST = store.getters.USER === null;

    const BASE_ROUTE = IS_GUEST ? '/login' : '/';
    const GUEST_PAGES = !!(to.meta?.CAN_ENTER?.IS_GUEST);

    if (!IS_GUEST && to.name === 'Login') {
        next(BASE_ROUTE);
    }

    if (IS_GUEST && !GUEST_PAGES) {
        next(BASE_ROUTE);
        return;
    }

    next();
});

export default Router;

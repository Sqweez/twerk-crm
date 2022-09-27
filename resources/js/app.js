import Vue from 'vue';
import App from './App.vue';
import router from './router/router';
import vuetify from "./plugins/vuetify";
import store from "./store";
import axios from 'axios';
import './filters/filters';
import loadingPlugin from "./utils/loadingPlugin";
axios.defaults.withCredentials = true;

import vuePlugins from "@/utils/vuePlugins";
import GlobalComponents from '@/components/GlobalComponents';

Vue.use(loadingPlugin);
Vue.use(vuePlugins);

GlobalComponents.connect();
Vue.config.productionTip = false;

const app = new Vue({
    el: '#app',
    router,
    store,
    vuetify,
    components: {App}
});



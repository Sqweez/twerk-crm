import ToastService from "@/utils/toastService";
import LoadingService from "@/utils/loadingService";
import ColorService from "@/utils/colorService";
import store from "@/store";
import {mapGetters} from 'vuex';
import DatePlugin from '@/utils/datePlugin';
import Roles from '@/common/enums/roles';

export default {
    install(Vue, options) {
        Vue.mixin({
            methods: {
                $evaluate: param => eval('this.'+param)
            },
            computed: {
                $date () {
                    return new DatePlugin();
                },
                $toast() {
                    return new ToastService();
                },
                $loading() {
                    return new LoadingService(store)
                },
                $color () {
                    return new ColorService();
                },
                IS_LOADING() {
                    return this.$store.getters.IS_LOADING;
                },
                $auth() {
                    return this.$store.getters.USER;
                },
                IS_LOADING_STATE () {
                    return this.IS_LOADING;
                },
                IS_SUPERUSER () {
                    return this.$store.getters.USER && this.$store.getters.USER.is_super_user;
                },
                IS_TRAINER () {
                    return this.$auth.roles.map(r => r.id).includes(Roles.ROLE_TRAINER);
                },
                IS_BOSS () {
                    return this.$auth.roles.map(r => r.id).includes(Roles.ROLE_BOSS);
                },
                ...mapGetters({
                    halls: 'halls',
                    subscriptionTimeTypes: 'subscription_time_types'
                }),
               /* halls () {
                    return this.$store.getters.halls;
                },
                subscriptionTimeTypes () {
                    return this.$store.getters.subscriptionTimeTypes;
                }*/
            }
        })
    }
}

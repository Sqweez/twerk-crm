import ToastService from "@/utils/toastService";
import LoadingService from "@/utils/loadingService";
import ColorService from "@/utils/colorService";
import store from "@/store";

export default {
    install(Vue, options) {
        Vue.mixin({
            methods: {
                $evaluate: param => eval('this.'+param)
            },
            computed: {
                $toast() {
                    return new ToastService();
                },
                $loading() {
                    return new LoadingService(store)
                },
                $color() {
                    return new ColorService();
                },
                IS_LOADING() {
                    return this.$store.getters.IS_LOADING;
                },
                $auth() {
                    return this.$store.getters.USER;
                }
            }
        })
    }
}

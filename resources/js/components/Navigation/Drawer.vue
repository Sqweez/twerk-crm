<template>
    <div class="mdl-layout__drawer">
        <header>KAIF | CRM</header>
        <div class="scroll__wrapper" id="scroll__wrapper">
            <div class="scroller" id="scroller">
                <div class="scroll__container" id="scroll__container">
                    <nav class="mdl-navigation">
                        <DrawerLink v-for="(link, key) of navigations"
                                    :link="link"
                                    :key="key" />
                    </nav>
                </div>
            </div>
            <div class='scroller__bar' id="scroller__bar"></div>
        </div>
    </div>
</template>

<script>
import routes from '@/router/routes';
import DrawerLink from "./DrawerLink";
export default {
    data: () => ({}),
    components: {
      DrawerLink
    },
    computed: {
        loginChecked () {
            return this.$store.getters.LOGIN_CHECKED;
        },
        navigations() {
            return this.$store.getters.navigations.filter(n => {
                if (!(this.loginChecked)) {
                    return false;
                }
                if (!this.$auth) {
                    return false;
                }
                const route = routes.find(route => route.path === n.url);
                const canEnter = route.meta?.CAN_ENTER;
                const roles = this.$auth.roles.map(r => r.id);
                if (canEnter === undefined) {
                    return true;
                } else {
                    return canEnter.some(role => roles.includes(role));
                }
            });
        },
        is_admin() {
            return this.$store.getters.IS_ADMIN;
        },
        is_observer() {
            return this.$store.getters.IS_OBSERVER;
        },
        is_seller() {
            return this.$store.getters.IS_SELLER;
        },
        is_moderator() {
            return this.$store.getters.IS_MODERATOR;
        }
    },
    methods: {
        openSubMenu(e) {
            if (e.target.parentElement.classList.contains('sub-navigation')) {
                // e.target.parentElement.classList.toggle('sub-navigation--show');
                // e.target.classList.toggle('mdl-navigation__link--current');
            }
        }
    }
}
</script>

<style scoped>

</style>

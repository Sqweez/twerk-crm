<template>
    <v-app>
        <div>
            <main-template v-show="layout === 'MainTemplate'"/>
            <login-template v-show="layout === 'LoginTemplate'"/>
            <default-template v-if="layout === 'DefaultTemplate'"/>
            <div v-if="!loginChecked" class="fullscreen-overlay">
                <v-progress-circular indeterminate color="red" size="60"></v-progress-circular>
            </div>
        </div>
    </v-app>
</template>

<script>

    import MainTemplate from './templates/MainTemplate';
    import LoginTemplate from './templates/LoginTemplate';
    import DefaultTemplate from '@/templates/DefaultTemplate';

    export default {
        components: {
            DefaultTemplate,
            MainTemplate, LoginTemplate
        },
        computed: {
            isLoggedIn () {
                return this.$store.getters.LOGGED_IN;
            },
            loginChecked () {
                return this.$store.getters.LOGIN_CHECKED;
            },
            layout() {
                if (this.loginChecked && !this.isLoggedIn) {
                    return 'LoginTemplate';
                }
                return 'MainTemplate';//this.isLoggedIn ? 'MainTemplate' : 'LoginTemplate';
            }
        }
    }
</script>

<style scoped>
    .fullscreen-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #000;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 100;
    }
</style>

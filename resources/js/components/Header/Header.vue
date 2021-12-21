<template>
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <div class="mdl-layout-spacer"></div>
            <div class="avatar-dropdown" id="icon" v-if="LOGGED_IN" @click="showDropdown = !showDropdown">
                <span>{{ USER.name}}</span>
            </div>


            <button @click="logout">Выйти</button>
            <!-- Account dropdawn-->

            <ul class="mdl-menu mdl-list mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect mdl-shadow--2dp account-dropdown"
                v-if="LOGGED_IN"
                for="icon">
                <a href="#" @click.prevent="logout">
                    <li class="mdl-menu__item mdl-list__item">
                        <span class="mdl-list__item-primary-content">
                            <i class="material-icons mdl-list__item-icon text-color--secondary">exit_to_app</i>
                            Выйти
                        </span>
                    </li>
                </a>
            </ul>

          <!--  <button id="more"
                    class="mdl-button mdl-js-button mdl-button&#45;&#45;icon">
                <i class="material-icons">more_vert</i>
            </button>

            <ul class="mdl-menu mdl-menu&#45;&#45;bottom-right mdl-js-menu mdl-js-ripple-effect mdl-shadow&#45;&#45;2dp settings-dropdown"
                for="more">
                <li class="mdl-menu__item">
                    Settings
                </li>
                <a class="mdl-menu__item" href="https://github.com/CreativeIT/getmdl-dashboard/issues">
                    Support
                </a>
                <li class="mdl-menu__item">
                    F.A.Q.
                </li>
            </ul>-->
        </div>
    </header>
</template>

<script>
    import {mapGetters} from 'vuex';
    export default {
        computed: {
            ...mapGetters([
                'USER',
                'LOGGED_IN',
                'IS_MALOY'
            ])
        },
        watch: {
            showDropdown() {
                const menuContainer = document.querySelector('.mdl-menu__container');
                if (menuContainer) {
                    if (this.showDropdown) {
                        if (!menuContainer.classList.contains('is-visible')) {
                            menuContainer.classList.add('is-visible');
                        }
                    } else {
                        if (menuContainer.classList.contains('is-visible')) {
                            menuContainer.classList.remove('is-visible');
                        }
                    }
                }
            }
        },
        data: () => ({
            showDropdown: true,
        }),
        methods: {
            async logout() {
                await this.$store.dispatch('LOGOUT');
                window.location.reload();
            }
        }
    }
</script>

<style scoped lang="scss">
    .avatar-dropdown {
        .account__dropdown {
            position: absolute;
            left: 0;
            bottom: -26px;
            display: flex;
            flex-direction: column;
            background-color: #202020;
            list-style: none;
            min-width: 100%;

            li {

                a {
                    text-decoration: none;
                    color: #ffffff!important;;
                }
            }
        }
    }
</style>

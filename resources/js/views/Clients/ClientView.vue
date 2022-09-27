<template>
    <div v-if="isClientReady">
        <v-row>
            <v-col cols="2">
                <i-card-page no-title>
                    <div class="d-flex flex-column">
                        <div v-if="client.avatar" style="width: 150px; height: 150px; overflow: hidden; margin: 0 auto;">
                            <img :src="client.avatar" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div style="">
                            <v-list>
                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title>
                                            {{ client.name }}
                                        </v-list-item-title>
                                        <v-list-item-subtitle>
                                            Имя
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title>
                                            {{ client.phone }}
                                        </v-list-item-title>
                                        <v-list-item-subtitle>
                                            Телефон
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </div>
                    </div>
                </i-card-page>
            </v-col>
            <v-col cols="10">
                <i-card-page title="Рабочее пространство">
                    <v-expansion-panels>
                        <v-expansion-panel
                        >
                            <v-expansion-panel-header color="blue darken-3">
                                Купленные абонементы
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                                @TODO
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-expansion-panels>
                    <client-price-list />
                </i-card-page>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import ClientPriceList from '@/components/Client/ClientPriceList';

export default {
    components: {ClientPriceList},
    data: () => ({}),
    computed: {
        ...mapGetters({
            client: 'singleClient',
        }),
        isClientReady () {
            return this.client && this.client?.id == this.$route.params.id;
        }
    },
    methods: {},
    async mounted() {
        this.$loading.enable();
        await this.$store.dispatch('getClient', this.$route.params.id);
        await this.$store.dispatch('getSubscriptions');
        await this.$store.dispatch('getUsers');
        this.$loading.disable();
    }
}
</script>

<style scoped lang="scss">

</style>

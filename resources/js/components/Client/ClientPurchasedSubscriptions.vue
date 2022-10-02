<template>
    <div>
        <v-expansion-panels>
            <v-expansion-panel
            >
                <v-expansion-panel-header color="blue darken-3">
                    Купленные абонементы
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                    <v-expansion-panels>
                        <v-expansion-panel v-for="sale of client.sales" :key="sale.id">
                            <v-expansion-panel-header color="darken-3" :color="sale.is_active ? 'green' : 'red'">
                                {{ sale.subscription_name }}
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <div class="d-flex">
                                    <v-list>
                                        <v-list-item>
                                            <v-list-item-content>
                                                <v-list-item-title>
                                                    {{ sale.active_until ? sale.active_until : 'Не активирован' }}
                                                </v-list-item-title>
                                                <v-list-item-subtitle>
                                                    Активен до
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item>
                                            <v-list-item-content>
                                                <v-list-item-title>
                                                    {{ sale.visits_remaining }}
                                                </v-list-item-title>
                                                <v-list-item-subtitle>
                                                    Осталось посещений
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item>
                                            <v-list-item-content>
                                                <v-list-item-title>
                                                    {{ sale.subscription_type }}
                                                </v-list-item-title>
                                                <v-list-item-subtitle>
                                                    Тип абонемента
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item>
                                            <v-list-item-content>
                                                <v-list-item-title>
                                                    {{ sale.current_trainer.name }}
                                                </v-list-item-title>
                                                <v-list-item-subtitle>
                                                    Тренер
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-list>
                                    <div class="ml-12 pt-4">
                                        <v-btn
                                            color="success"
                                            v-if="sale.is_activated && sale.is_active"
                                            @click="currentSale = sale; clientWriteoffModalShow = true;"
                                        >
                                            Списать
                                        </v-btn>
                                        <v-btn color="success" v-if="!sale.is_activated" @click="activateSale(sale)">
                                            Активировать
                                        </v-btn>
                                    </div>
                                </div>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-expansion-panels>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </v-expansion-panels>
        <ClientWriteOffVisitModal
            @cancel="clientWriteoffModalShow = false; currentSale = {};"
            :state="clientWriteoffModalShow"
            :sale="currentSale"/>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';
import ClientWriteOffVisitModal from '@/components/Client/ClientWriteOffVisitModal';

export default {
    components: {ClientWriteOffVisitModal},
    data: () => ({
        clientWriteoffModalShow: false,
        currentSale: {},
    }),
    computed: {
        ...mapGetters({
            client: 'singleClient',
        }),
    },
    methods: {
        ...mapActions({
            $activateSale: 'activateSale'
        }),
        async activateSale (sale) {
            this.$loading.enable();
            await this.$activateSale(sale);
            this.$toast.success('Абонемент успешно активирован!')
            this.$loading.disable();
        }
    }
}
</script>

<style scoped lang="scss">

</style>

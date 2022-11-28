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
                                        <v-list-item>
                                            <v-list-item-content>
                                                <v-list-item-title>
                                                    {{ sale.sale_date }}
                                                </v-list-item-title>
                                                <v-list-item-subtitle>
                                                    Дата покупки
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-list>
                                    <div class="ml-12 pt-4">
                                        <ul style="list-style: none; display: flex; flex-direction: column; row-gap: 15px;">
                                            <li>
                                                <v-btn
                                                    color="success"
                                                    v-if="sale.is_activated && sale.is_active"
                                                    @click="currentSale = sale; clientWriteoffModalShow = true;"
                                                >
                                                    Списать <v-icon>mdi-check</v-icon>
                                                </v-btn>
                                            </li>
                                            <li>
                                                <v-btn
                                                    color="blue darken-2"
                                                    @click="currentSale = sale; showClientSaleEditModal = true;"
                                                >
                                                    Редактировать <v-icon>mdi-pencil</v-icon>
                                                </v-btn>
                                            </li>
                                            <li>
                                                <v-btn
                                                    @click="cancelSubscription(sale.id)"
                                                    v-if="sale.is_activated && sale.is_active"
                                                    color="error"
                                                >
                                                    Отменить продажу <v-icon>mdi-cancel</v-icon>
                                                </v-btn>
                                            </li>
                                            <li>
                                                <v-btn color="success" v-if="!sale.is_activated" @click="activateSale(sale)">
                                                    Активировать <v-icon>mdi-check</v-icon>
                                                </v-btn>
                                            </li>
                                        </ul>
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
        <EditClientSaleModal
            :state="showClientSaleEditModal"
            :sale="currentSale"
            @cancel="showClientSaleEditModal = false; currentSale = {};"
        />
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';
import ClientWriteOffVisitModal from '@/components/Client/ClientWriteOffVisitModal';
import EditClientSaleModal from '@/components/Client/EditClientSaleModal';

export default {
    components: {EditClientSaleModal, ClientWriteOffVisitModal},
    data: () => ({
        clientWriteoffModalShow: false,
        showClientSaleEditModal: false,
        currentSale: {},
    }),
    computed: {
        ...mapGetters({
            client: 'singleClient',
        }),
    },
    methods: {
        ...mapActions({
            $activateSale: 'activateSale',
            $cancelSubscription: 'cancelSubscription',
        }),
        async activateSale (sale) {
            this.$loading.enable();
            await this.$activateSale(sale);
            this.$toast.success('Абонемент успешно активирован!')
            this.$loading.disable();
        },
        async cancelSubscription (sale) {
            this.$confirm('Вы действительно хотите отменить выбранный абонемент?')
                .then(async () => {
                    this.$loading.enable();
                    this.$cancelSubscription(sale);
                    this.$toast.success('Абонемент успешно отменен!');
                    this.$loading.disable();
                })
        }
    }
}
</script>

<style scoped lang="scss">

</style>

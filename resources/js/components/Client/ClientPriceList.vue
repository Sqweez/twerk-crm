<template>
    <v-expansion-panels class="my-4">
        <v-expansion-panel
        >
            <v-expansion-panel-header color="purple darken-2">
                Абонементы для продажи
            </v-expansion-panel-header>
            <v-expansion-panel-content>
                <v-text-field
                    class="mt-2"
                    v-model="search"
                    solo
                    clearable
                    label="Поиск..."
                    single-line
                    hide-details
                ></v-text-field>
                <v-data-table
                    :search="search"
                    :headers="headers"
                    :items="subscriptions"
                    :items-per-page="10"
                >
                    <template v-slot:item.price="{ item }">
                        {{ item.price | priceFilters }}
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-btn color="success" small @click="onSaleHandle(item)">
                            Продать
                        </v-btn>
                    </template>
                </v-data-table>
            </v-expansion-panel-content>
        </v-expansion-panel>
        <client-sale-modal
            :state="showSaleModal"
            :subscription="currentSubscription"
            @cancel="showSaleModal = false; currentSubscription = {};"
        />
    </v-expansion-panels>
</template>

<script>
import {mapGetters} from 'vuex';
import ClientSaleModal from '@/components/Client/ClientSaleModal';

export default {
    components: {ClientSaleModal},
    data: () => ({
        currentSubscription: {},
        showSaleModal: false,
        search: '',
        headers: [
            {
                value: 'name',
                text: 'Название'
            },
            {
                value: 'price',
                text: 'Стоимость'
            },
            {
                value: 'validity_days',
                text: 'Срок действия, дней'
            },
            {
                value: 'validity_visits',
                text: 'Количество посещений'
            },
            {
                value: 'type.name',
                text: 'Тип'
            },
            {
                value: 'actions',
                text: 'Действие'
            }
        ],
    }),
    computed: {
        ...mapGetters({
            'subscriptions': 'subscriptions'
        })
    },
    methods: {
        onSaleHandle (subscription) {
            console.log(subscription);
            this.currentSubscription = subscription;
            this.showSaleModal = true;
        }
    }
}
</script>

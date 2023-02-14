<template>
    <div>
        <i-card-page title="Истекающие абонементы">
            <v-data-table
                :items="subscriptions"
                :headers="headers"
                no-data-text="Нет истекающих абонементов"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn color="success" icon @click="openWA(item)">
                        <v-icon>mdi-whatsapp</v-icon>
                    </v-btn>
                </template>
            </v-data-table>
        </i-card-page>
    </div>
</template>

<script>
import axiosClient from '@/utils/axiosClient';

export default {
    data: () => ({
        subscriptions: [],
        headers: [
            {
                value: 'client.name',
                text: 'Клиент'
            },
            {
                value: 'subscription.name',
                text: 'Абонемент'
            },
            {
                value: 'hall',
                text: 'Зал'
            },
            {
                value: 'current_trainer.name',
                text: 'Тренер'
            },
            {
                value: 'date',
                text: 'Дата покупки'
            },
            {
                value: 'actions',
                text: 'Действие'
            }
        ],
    }),
    computed: {},
    methods: {
        async getAlmostExpiredSubscriptions () {
            this.$loading.enable();
            const { data: { data } } = await axiosClient.get('/clients/subscriptions/expiring');
            this.subscriptions = data;
            this.$loading.disable();
        },
        openWA (item) {
            const link = document.createElement('a');
            link.href = `https://api.whatsapp.com/send?phone=${item.client_phone}`;
            link.target = '_blank';
            link.click();
        }
    },
    async mounted() {
        await this.getAlmostExpiredSubscriptions();
    }
}
</script>

<style scoped lang="scss">

</style>

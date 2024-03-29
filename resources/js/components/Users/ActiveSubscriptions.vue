<template>
    <div>
        <v-alert
            class="my-3"
            color="indigo"
            dark
        >
            <ul>
                <li>
                    Общая сумма: {{ totalAmount | priceFilters }}
                </li>
                <li>
                    Количество абонементов: {{ reports.length }}
                </li>
            </ul>
        </v-alert>
        <v-select
            label="Фильтр по типу абонемента"
            :items="subscriptionTypeFilter"
            v-model="subscriptionTypeId"
            item-text="name"
            item-value="id"
        />
        <v-text-field
            label="Поиск"
            v-model="search"
            append-icon="search"
        />
        <v-data-table
            :search="search"
            :items="filteredItems"
            :headers="headers"
        >
            <template v-slot:item.subscription="{item}">
                {{ item.subscription.name }}
            </template>
            <template v-slot:item.price="{item}">
                {{ item.subscription.price | priceFilters }}
            </template>
            <template v-slot:item.client="{item}">
                <span>
                    {{ item.client.name }}
                </span>
                <v-btn icon @click="$router.push(`/clients/${item.client.id}`)">
                    <v-icon>mdi-eye</v-icon>
                </v-btn>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import axiosClient from '@/utils/axiosClient';

export default {
    data: () => ({
        reports: [],
        subscriptionTypeId: -1,
        search: '',
        headers: [
            {
                value: 'client',
                text: 'Клиент'
            },
            {
                value: 'subscription',
                text: 'Абонемент'
            },
            {
                value: 'price',
                text: 'Стоимость'
            },
            {
                value: 'active_until',
                text: 'Активен до'
            },
            {
                value: 'visits_remaining',
                text: 'Осталось посещений'
            },
            {
                value: 'user.name',
                text: 'Кто продал'
            },
            {
                value: 'payment_type',
                text: 'Способ оплаты'
            },
            {
                value: 'date',
                text: 'Дата'
            }
        ]
    }),
    async mounted () {
        this.$loading.enable();
        const { data: { data } } = await axiosClient.get(`users/${this.userId}/subscriptions`);
        this.reports = data;
        this.$loading.disable();
    },
    computed: {
        totalAmount () {
            return this.reports.reduce((a, c) => {
                return a + c.price;
            }, 0);
        },
        filteredItems () {
            return this.reports.filter(r => {
                return this.subscriptionTypeId === -1 ? true : r.subscription_type_id === this.subscriptionTypeId;
            })
        },
        subscriptionTypeFilter () {
            return this.$store.getters.subscription_type_filters;
        }
    },
    methods: {},
    props: {
        userId: {
            type: Number|String,
            required: true
        }
    }
}
</script>

<style scoped lang="scss">

</style>

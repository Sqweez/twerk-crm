<template>
    <div>
        <v-text-field
            label="Поиск"
            v-model="search"
            append-icon="search"
        />
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
        <v-data-table
            :search="search"
            :items="reports"
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
export default {
    data: () => ({
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
                value: 'trainer.name',
                text: 'Тренер'
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
    computed: {
        reports () {
            return this.$store.getters.sales;
        },
        totalAmount () {
            return this.reports.reduce((a, c) => {
                return a + c.subscription.price;
            }, 0);
        }
    },
    methods: {}
}
</script>

<style scoped lang="scss">

</style>

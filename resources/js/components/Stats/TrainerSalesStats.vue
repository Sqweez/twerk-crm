<template>
    <div>
        <v-select
            label="Тренер"
            :items="trainers"
            item-value="id"
            item-text="name"
            v-model="trainerId"
        />
        <v-select
            label="Тип абонемента"
            :items="types"
            item-value="id"
            item-text="name"
            v-model="typeId"
        />
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
            <template v-slot:item.actions="{ item }">
                <v-btn color="success" icon @click="openWA(item)">
                    <v-icon>mdi-whatsapp</v-icon>
                </v-btn>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import {openWA} from '@/utils/helpers';

export default {
    data: () => ({
        trainerId: -1,
        typeId: -1,
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
            },
            {
                value: 'actions',
                text: 'Действие'
            }
        ]
    }),
    computed: {
        types () {
            return [
                {
                    id: -1,
                    name: 'Все'
                },
                ...this.$store.getters.subscription_types
            ];
        },
        trainers () {
            return [
                {
                    id: -1,
                    name: 'Все'
                },
                ...this.$store.getters.trainers
            ];
        },
        reports () {
            return this.$store
                .getters
                .trainer_sales
                .filter(t => {
                    return this.typeId === -1 ? true : t.subscription.type_id === this.typeId;
                });
        },
        totalAmount () {
            return this.reports.reduce((a, c) => {
                return a + c.subscription.price;
            }, 0);
        }
    },
    methods: {
        openWA (item) {
            openWA(item.phone)
        }
    }
}
</script>

<style scoped lang="scss">

</style>

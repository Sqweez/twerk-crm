<template>
    <div>
        <v-expansion-panels>
            <v-expansion-panel
            >
                <v-expansion-panel-header color="lime darken-4">
                    История посещений
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                    <v-data-table
                        :items="client.visits"
                        :headers="headers"
                        no-data-text="Клиент еще не посещал занятия 😔"
                    />
                </v-expansion-panel-content>
            </v-expansion-panel>
        </v-expansion-panels>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
    data: () => ({
        headers: [
            {
                value: 'subscription.name',
                text: 'Абонемент'
            },
            {
                value: 'trainer.name',
                text: 'Тренер'
            },
            {
                value: 'hall.name',
                text: 'Зал'
            },
            {
                value: 'time',
                text: 'Время'
            },
            {
                value: 'user.name',
                text: 'Кто списал тренировку'
            },
            {
                value: 'date',
                text: 'Дата'
            }
        ],
    }),
    computed: {
        ...mapGetters({
            client: 'singleClient',
        }),
    },
    methods: {}
}
</script>

<style scoped lang="scss">

</style>

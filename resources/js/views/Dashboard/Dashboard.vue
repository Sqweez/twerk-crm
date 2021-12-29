<template>
    <div>
        <v-row>
            <v-col sm="12" md="6">
                <v-card>
                    <v-card-title>
                        Клиенты с абонементом, истекающим сегодня
                    </v-card-title>
                    <v-card-text>
                        <v-simple-table v-slot:default>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Имя</th>
                                <th>Телефон</th>
                                <th>Дата истечения</th>
                                <th>Написать</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(client, key) of nearlyClients" :key="key">
                                <td>{{ key + 1 }}</td>
                                <td>{{ client.client_name }}</td>
                                <td>{{ client.phone }}</td>
                                <td>{{ client.expire_date }}</td>
                                <td>
                                    <v-btn text color="primary" @click="sendMessage(client)">
                                        Отправить сообщение
                                    </v-btn>
                                </td>
                            </tr>
                            </tbody>
                        </v-simple-table>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col sm="12" md="6">
                <v-card>
                    <v-card-title>
                        Клиенты с истекшим абонементом
                    </v-card-title>
                    <v-card-text>
                        <v-simple-table v-slot:default>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Имя</th>
                                <th>Телефон</th>
                                <th>Дата истечения</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(client, key) of outdatedClients" :key="key">
                                <td>{{ key + 1 }}</td>
                                <td>{{ client.client_name }}</td>
                                <td>{{ client.phone }}</td>
                                <td>{{ client.expire_date }}</td>
                            </tr>
                            </tbody>
                        </v-simple-table>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col sm="12" md="6">
                <v-card>
                    <v-card-title>
                        Клиенты с абонементом, истекающим в течении 3 дней
                    </v-card-title>
                    <v-card-text>
                        <v-simple-table v-slot:default>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Имя</th>
                                <th>Телефон</th>
                                <th>Дата истечения</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(client, key) of nearlyClients" :key="key">
                                <td>{{ key + 1 }}</td>
                                <td>{{ client.client_name }}</td>
                                <td>{{ client.phone }}</td>
                                <td>{{ client.expire_date }}</td>
                            </tr>
                            </tbody>
                        </v-simple-table>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script>

export default {
    data: () => ({
        items: ['Сегодня', 'Текущая неделя', 'Текущий месяц', 'Последние 3 месяца'],
    }),
    components: {},
    computed: {
        nearlyClients() {
            return this.$store.getters.nearlyClients;
        },
        outdatedClients() {
            return this.$store.getters.outdatedClients;
        },
        todayClients() {
            return this.$store.getters.todayClients;
        },
    },
    async mounted() {
        this.$loading.enable();
        await this.$store.dispatch('getNearlyClients');
        await this.$store.dispatch('getOutdatedClients');
        await this.$store.dispatch('getTodayClients');
        this.$loading.disable();
    },
    methods: {
        sendMessage(client) {
            const message = `Добрый день, ${client.client_name}! Напоминаем, что сегодня у вас истекает срок действия абонемента!`;
            const url = `https://api.whatsapp.com/send?phone=${client.phone}&text=${message}`;
            window.location.href = url;
        }
    },
}
</script>

<style scoped>
.text-shadow {
    text-shadow: 4px 4px 4px rgba(0, 0, 0, 0.4);
}

iframe {
    width: 100%;
    height: 600px;
}
</style>

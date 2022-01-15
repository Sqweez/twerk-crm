<template>
    <div>
        <v-row>
            <v-col sm="12" md="6">
                <dashboard-client-table
                    title="Клиенты с абонементом, истекающим сегодня"
                    :clients="todayClients"
                    :on-send="sendMessage"
                />
            </v-col>
            <v-col sm="12" md="6">
                <dashboard-client-table
                    title="Клиенты с истекшим абонементом"
                    :clients="outdatedClients"
                    :on-send="sendEmptyMessage"
                />
            </v-col>
            <v-col sm="12" md="6">
                <dashboard-client-table
                    title="Клиенты с абонементом, истекающим в течении 3 дней"
                    :clients="nearlyClients"
                    :on-send="sendEmptyMessage"
                />
            </v-col>
        </v-row>
    </div>
</template>

<script>

import axiosClient from "../../utils/axiosClient";
import DashboardClientTable from "../../components/Widgets/DashboardClientTable";

export default {
    data: () => ({
        items: ['Сегодня', 'Текущая неделя', 'Текущий месяц', 'Последние 3 месяца'],
        whatsappTemplate: '',
    }),
    components: {DashboardClientTable},
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
        const { data } = await axiosClient.get('settings/whatsapp_message');
        this.whatsappTemplate = data.data.setting;
        this.$loading.disable();
    },
    methods: {
        sendMessage(client) {
            const message = this.whatsappTemplate.replace('%ИМЯ%', client.client_name);
            window.location.href = `https://api.whatsapp.com/send?phone=${client.phone}&text=${message}`;
        },
        sendEmptyMessage (client) {
            const message = '';
            window.location.href = `https://api.whatsapp.com/send?phone=${client.phone}&text=${message}`;
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

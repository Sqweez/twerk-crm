<template>
    <div>
        <v-row>
            <v-col  sm="3" lg="3" md="3">
                <WeatherWidget />
            </v-col>
        </v-row>
    </div>
</template>

<script>

import axiosClient from "../../utils/axiosClient";
import DashboardClientTable from "../../components/Widgets/DashboardClientTable";
import WeatherWidget from '@/components/Widgets/WeatherWidget';

export default {
    data: () => ({
        items: ['Сегодня', 'Текущая неделя', 'Текущий месяц', 'Последние 3 месяца'],
        whatsappTemplate: '',
    }),
    components: {WeatherWidget, DashboardClientTable},
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

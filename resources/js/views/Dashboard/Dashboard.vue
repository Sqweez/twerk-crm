<template>
    <div>
        <v-row>
            <v-col  sm="12" lg="3" md="3">
                <WeatherWidget />
            </v-col>
            <v-col sm="12" lg="9" md="9" v-if="IS_TRAINER">
                <self-motivation-widget />
            </v-col>
            <v-col sm="12" lg="12" md="12" v-if="IS_TRAINER">
                <user-visits-widget />
            </v-col>
            <v-col sm="12" lg="12" md="12" v-if="IS_BOSS">
                <team-motivation-widget />
            </v-col>
        </v-row>
    </div>
</template>

<script>

import DashboardClientTable from "../../components/Widgets/DashboardClientTable";
import WeatherWidget from '@/components/Widgets/WeatherWidget';
import SelfMotivationWidget from '@/components/Widgets/SelfMotivationWidget';
import UserVisitsWidget from '@/components/Widgets/UserVisitsWidget';
import TeamMotivationWidget from '@/components/Widgets/TeamMotivationWidget';

export default {
    data: () => ({
        items: ['Сегодня', 'Текущая неделя', 'Текущий месяц', 'Последние 3 месяца'],
        whatsappTemplate: '',
    }),
    components: {TeamMotivationWidget, UserVisitsWidget, SelfMotivationWidget, WeatherWidget, DashboardClientTable},
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

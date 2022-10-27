<template>
    <div>
        <i-card-page title="Статистика">
            <v-row>
                <v-col cols="12" xl="6">
                    <v-tabs v-model="tab">
                        <v-tab>
                            Гости
                        </v-tab>
                        <v-tab>
                            Продажи
                        </v-tab>
                        <v-tab>
                            Тренера
                        </v-tab>
                    </v-tabs>
                </v-col>
                <v-col cols="12" xl="3">
                    <v-select
                        :disabled="!IS_SUPERUSER"
                        :items="dateFilters"
                        item-text="name"
                        item-value="value"
                        v-model="currentDate"
                        label="Время:"
                        @change="loadReport"
                    />
                </v-col>
                <v-col cols="12" xl="3" v-if="currentDate === 4">
                    <v-menu
                        ref="dateMenu"
                        v-model="dateMenu"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        :return-value.sync="dates"
                        transition="scale-transition"
                        min-width="auto"
                        offset-y
                    >
                        <template v-slot:activator="{ on }">
                            <v-text-field
                                v-model="dates.map(d => d.split('-').reverse().join('.')).join('~')"
                                label="Произвольный период"
                                readonly
                                v-on="on"
                            />
                        </template>
                        <v-date-picker
                            v-model="dates"
                            no-title
                            scrollable
                            range
                        >
                            <div class="flex-grow-1"></div>
                            <v-btn
                                text
                                outlined
                                color="primary"
                                @click="dateMenu = false"
                            >
                                Отмена
                            </v-btn>
                            <v-btn
                                text
                                outlined
                                color="primary"
                                @click="changeCustomDate(dateMenu, dates) "
                            >
                                OK
                            </v-btn>
                        </v-date-picker>
                    </v-menu>
                </v-col>
            </v-row>

            <v-tabs-items v-model="tab">
                <v-tab-item>
                   <client-visits-stats />
                </v-tab-item>
                <v-tab-item>
                    <client-sales-stats />
                </v-tab-item>
                <v-tab-item>
                    <trainer-visits-stats />
                </v-tab-item>
            </v-tabs-items>
        </i-card-page>
    </div>
</template>

<script>
import moment from "moment";
import {mapActions} from 'vuex';
import ClientVisitsStats from '@/components/Stats/ClientVisitsStats';
import ClientSalesStats from '@/components/Stats/ClientSalesStats';
import TrainerVisitsStats from '@/components/Stats/TrainerVisitsStats';

const DATE_FORMAT = 'YYYY-MM-DD';

const DATE_FILTERS = {
    ALL_TIME: 1,
    CURRENT_MONTH: 2,
    TODAY: 3,
    CUSTOM_FILTER: 4,
    LAST_3_DAYS: 5,
};
export default {
    components: {TrainerVisitsStats, ClientSalesStats, ClientVisitsStats},
    data: () => ({
        tab: null,
        currentDate:  [
            moment().format(DATE_FORMAT),
            moment().format(DATE_FORMAT),
        ],
        dateFilters: [
            {
                name: 'Сегодня',
                value: [
                    moment().format(DATE_FORMAT),
                    moment().format(DATE_FORMAT),
                ],
            },
            {
                name: 'Вчера',
                value: [
                    moment().subtract(1, 'days').format(DATE_FORMAT),
                    moment().subtract(1, 'days').format(DATE_FORMAT),
                ],
            },
            {
                name: 'Последние 3 дня',
                value: [
                    moment().subtract(3, 'days').format(DATE_FORMAT),
                    moment().format(DATE_FORMAT),
                ],
            },
            {
                name: 'За текущий месяц',
                value: [
                    moment().startOf('month').format(DATE_FORMAT),
                    moment().format(DATE_FORMAT),
                ],
            },
            {
                name: 'За все время',
                value: [
                    moment.unix(1).format(DATE_FORMAT),
                    moment().format(DATE_FORMAT)
                ],
            },
            {
                name: 'Произвольно',
                value: DATE_FILTERS.CUSTOM_FILTER
            },
        ],
        dateMenu: null,
        dates: [],
    }),
    computed: {},
    async created () {
        await this.loadReport();
    },
    methods: {
        ...mapActions({
            $getReports: 'getReports'
        }),
        changeCustomDate () {
            this.$refs.dateMenu.save(this.dates);
            this.loadReport();
        },
        async loadReport () {
            if (this.currentDate === DATE_FILTERS.CUSTOM_FILTER && !(this.dates.length === 2)) {
                return false;
            }
            const dateObject = {
                start: this.currentDate === DATE_FILTERS.CUSTOM_FILTER ? this.dates[0] : this.currentDate[0],
                finish: this.currentDate === DATE_FILTERS.CUSTOM_FILTER ? this.dates[1] : this.currentDate[1],
            };
            try {
                this.$loading.enable();
                await this.$getReports(dateObject);
            } catch (e) {}
            finally {
                this.$loading.disable();
            }
        }
    }
}
</script>

<style scoped lang="scss">

</style>

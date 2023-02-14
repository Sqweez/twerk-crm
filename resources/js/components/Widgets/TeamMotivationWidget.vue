<template>
    <div>
        <i-card-page title="Выполнение общего плана">
            <v-select
                label="Дата"
                v-model="date"
                :items="currentMonths"
                item-text="name"
                item-value="value"
            />
            <div v-if="isLoading"
                 class="p-8 d-flex justify-center align-items-center"
            >
                <v-progress-circular
                    indeterminate
                    size="64"
                    color="danger"
                />
            </div>
            <v-simple-table v-slot:default v-else>
                <thead>
                <tr>
                    <th>Тренер</th>
                    <th>Зал</th>
                    <th>План</th>
                    <th>Факт</th>
                    <th>Процент выполнения</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, key) of planExecution.by_trainer" :key="key">
                    <td>{{ item.user_name }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.sale_count }}</td>
                    <td>{{ item.sale_count_fact }}</td>
                    <td>{{ item.sale_count_fact_percent }}%</td>
                </tr>

                <tr v-for="(item, key) of planExecution.total" :key="key">
                    <td><b>{{ item.user_name }}</b></td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.sale_count }}</td>
                    <td>{{ item.sale_count_fact }}</td>
                    <td>{{ item.sale_count_fact_percent }}%</td>
                </tr>
                </tbody>
            </v-simple-table>
        </i-card-page>
    </div>
</template>

<script>
import axiosClient from '@/utils/axiosClient';

export default {
    data: () => ({
        date: null,
        isLoading: true,
        planExecution: [],
    }),
    mounted() {
        this.date = this.currentMonths[0].value;
    },
    computed: {
        currentMonths () {
            return this.$date.parseMonthsDiff(8)
        }
    },
    methods: {
        async getPlan () {
            this.isLoading = true;
            const { data } = await axiosClient.get(`/economy/plan/total/${this.date}`);
            this.planExecution = data;
            this.isLoading = false;
        },
    },
    watch: {
        date: {
            immediate: true,
            handler: function (value) {
                if (value) {
                    this.getPlan();
                }
            }
        }
    }
}
</script>

<style scoped lang="scss">

</style>

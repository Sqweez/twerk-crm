<template>
    <div>
        <i-card-page title="Выполнение личного плана">
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
                    <th>Зал</th>
                    <th>План</th>
                    <th>Факт</th>
                    <th>Процент выполнения</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, key) of planExecution" :key="key">
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
            const { data } = await axiosClient.get(`/economy/plan/${this.$auth.id}/${this.date}`);
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

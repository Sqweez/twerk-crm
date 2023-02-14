<template>
    <div>
        <i-card-page title="План продаж">
            <v-simple-table v-slot:default>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Тренер</th>
                    <th>План (месяц)</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(plan, key) of plans" :key="key">
                    <td>{{ key + 1 }}</td>
                    <td>{{ plan.user_name }}</td>
                    <td>
                        <v-text-field
                            :label="currentPlan.name"
                            type="number"
                            v-for="(currentPlan, index) of plan.plans"
                            v-model.number="plans[key]['plans'][index].sale_count"
                        />
                    </td>
                </tr>
                </tbody>
            </v-simple-table>
            <v-btn color="success" @click="onSubmit" class="mt-4">
                Сохранить <v-icon>mdi-check</v-icon>
            </v-btn>
        </i-card-page>
    </div>
</template>

<script>
import axiosClient from '@/utils/axiosClient';

export default {
    data: () => ({
        plans: [],
    }),
    computed: {},
    methods: {
        async onSubmit () {
            this.$loading.enable();
            const { data } = await axiosClient.post('/plan', {
                plans: this.plans
            });
            this.$toast.success('План успешно обновлен!');
            this.plans = data;
            this.$loading.disable();
        }
    },
    async mounted () {
        this.$loading.enable();
        const { data } = await axiosClient.get('/plan');
        this.plans = data;
        this.$loading.disable();
    },
}
</script>

<style scoped lang="scss">

</style>

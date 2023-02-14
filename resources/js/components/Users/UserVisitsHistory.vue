<template>
    <div>
        <i-date-picker v-model="dates"/>
        <v-data-table
            :items="visits"
            :headers="headers"
        />
    </div>
</template>

<script>
import axiosClient from '@/utils/axiosClient';

export default {
    data: () => ({
        dates: [],
        visits: [],
        headers: [
            {
                value: 'client.name',
                text: 'Клиент'
            },
            {
                value: 'subscription.name',
                text: 'Абонемент'
            },
            {
                value: 'hall',
                text: 'Зал'
            },
            {
                value: 'user.name',
                text: 'Кто списал'
            },
            {
                value: 'date',
                text: 'Дата'
            }
        ]
    }),
    computed: {},
    methods: {
        async loadVisits () {
            const payload = {
                user_id: this.userId,
                start: this.dates[0],
                finish: this.dates[1]
            };

            const { data: { data } } = await axiosClient.get(`economy/trainer/visits?${new URLSearchParams(payload)}`);
            this.visits = data;
        }
    },
    props: {
        userId: {
            type: Number|String,
            required: true
        }
    },
    watch: {
        dates: {
            immediate: true,
            handler: function (value) {
                if (value.length === 2 && value.every(v => v)) {
                    this.loadVisits();
                }
            }
        }
    }

}
</script>

<style scoped lang="scss">

</style>

<template>
    <i-card-page title="Редактирование абонемента">
        <v-form v-if="!IS_LOADING_STATE">
            <v-text-field
                label="Название"
                v-model="subscription.name"
            />
            <v-text-field
                label="Стоимость"
                type="number"
                onkeydown="return !['e', 'E'].includes(event.key)"
                v-model="subscription.price"
            />
            <v-text-field
                label="Срок действия в днях"
                type="number"
                onkeydown="return !['e', 'E'].includes(event.key)"
                v-model="subscription.validity_days"
            />
            <v-text-field
                label="Количество посещений"
                type="number"
                onkeydown="return !['e', 'E'].includes(event.key)"
                v-model="subscription.validity_visits"
            />
            <v-select
                :items="types"
                item-value="id"
                item-text="name"
                v-model="subscription.type_id"
                label="Тип абонемента"
            />
            <v-btn color="success" @click="onCreate">
                Сохранить <v-icon>mdi-check</v-icon>
            </v-btn>
        </v-form>
    </i-card-page>
</template>

<script>
import axiosClient from '@/utils/axiosClient';

export default {
    data: () => ({
        subscription: null,
    }),
    async mounted () {
        const { data: { data } } = await axiosClient.get(`/subscriptions/${this.$route.params.id}`);
        this.subscription = data;
    },
    computed: {
        types () {
            return this.$store.getters.subscription_types;
        }
    },
    methods: {
        async onCreate () {
            if (!this.subscription.name) {
                return this.$toast.error('Введите название!');
            }
            this.$loading.enable();
            const payload = {...this.subscription};
            await axiosClient.patch(`/subscriptions/${payload.id}`, payload);
            this.$toast.success('Абонемент успешно отредактирован!');
            this.$loading.disable();
            return this.$router.push('/subscriptions');
        }
    }
}
</script>

<style scoped lang="scss">

</style>

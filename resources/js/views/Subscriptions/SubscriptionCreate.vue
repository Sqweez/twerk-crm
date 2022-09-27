<template>
    <i-card-page title="Создание абонемента">
       <v-form>
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
        subscription: {
            name: '',
            type_id: 1,
            price: 0,
            validity_days: 0,
            validity_visits: 0,
        }
    }),
    mounted () {

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
            await axiosClient.post('/subscriptions', payload);
            this.$toast.success('Абонемент успешно создан!');
            this.$loading.disable();
            return this.$router.push('/subscriptions');
        }
    }
}
</script>

<style scoped lang="scss">

</style>

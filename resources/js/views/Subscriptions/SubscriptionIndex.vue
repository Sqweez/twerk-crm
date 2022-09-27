<template>
    <i-card-page title="Абонементы">
        <v-btn @click="$router.push('/subscriptions/create')" color="success">
            Создать абонемент <v-icon>mdi-plus</v-icon>
        </v-btn>
        <v-text-field
            class="mt-2"
            v-model="search"
            solo
            clearable
            label="Поиск..."
            single-line
            hide-details
        ></v-text-field>
        <v-data-table
            :search="search"
            :headers="headers"
            :items="subscriptions"
            :items-per-page="10"
        >
            <template v-slot:item.price="{ item }">
                {{ item.price | priceFilters }}
            </template>
            <template v-slot:item.actions="{ item }">
                <v-btn icon @click="$router.push('/subscriptions/' + item.id)">
                    <v-icon>mdi-pencil</v-icon>
                </v-btn>
                <v-btn icon @click="confirmationModal = true; subscriptionId = item.id;">
                    <v-icon>mdi-delete</v-icon>
                </v-btn>
            </template>
        </v-data-table>
        <ConfirmationModal
            :state="confirmationModal"
            :on-confirm="deleteSubscription"
            v-on:cancel="subscriptionId = null; confirmationModal = false"
            message="Вы действительно хотите удалить выбранный абонемент?" />
    </i-card-page>
</template>

<script>
import {mapGetters} from 'vuex';
import ConfirmationModal from '@/components/Modal/ConfirmationModal';

export default {
    components: {ConfirmationModal},
    data: () => ({
        subscriptionId: null,
        confirmationModal: false,
        search: '',
        headers: [
            {
                value: 'name',
                text: 'Название'
            },
            {
                value: 'price',
                text: 'Стоимость'
            },
            {
                value: 'validity_days',
                text: 'Срок действия, дней'
            },
            {
                value: 'validity_visits',
                text: 'Количество посещений'
            },
            {
                value: 'type.name',
                text: 'Тип'
            },
            {
                value: 'actions',
                text: 'Действие'
            }
        ],
    }),
    async mounted () {
        this.$loading.enable();
        await this.$store.dispatch('getSubscriptions');
        this.$loading.disable();
    },
    computed: {
        ...mapGetters({
            'subscriptions': 'subscriptions'
        })
    },
    methods: {
        async deleteSubscription () {
            this.$loading.enable();
            await this.$store.dispatch('deleteSubscription', this.subscriptionId);
            this.subscriptionId = null;
            this.confirmationModal = false;
            this.$loading.disable();
        }
    }
}
</script>

<style scoped lang="scss">

</style>

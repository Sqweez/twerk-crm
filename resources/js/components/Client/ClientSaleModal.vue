<template>
    <base-modal
        :state="state"
        @cancel="$emit('cancel')"
        :title="`Продажа ${subscription.name}`"
        max-width="750"
    >
        <template #default>
            <v-select
                label="Тренер"
                v-model="sale.trainer_id"
                :items="trainers"
                item-text="name"
                item-value="id"
            />
            <v-select
                label="Зал"
                v-model="sale.hall_id"
                :items="halls"
                item-value="id"
                item-text="name"
            />
            <v-select
                label="Время"
                v-model="sale.time_id"
                :items="subscriptionTimeTypes"
                item-value="id"
                item-text="name"
            />
            <h6>Способ оплаты:</h6>
            <v-radio-group
                v-model="sale.payment_type"
                v-for="type of payment_types"
                :key="type.id"
                dense
            >
                <v-radio
                    dense
                    :label="type.name"
                    :value="type.id"
                />
            </v-radio-group>
        </template>
        <template #actions>
            <v-btn text @click="$emit('cancel')">
                Отмена
            </v-btn>
            <v-spacer />
            <v-btn text color="success" @click="onSale">
                Продать <v-icon>mdi-check</v-icon>
            </v-btn>
        </template>
    </base-modal>
</template>

<script>
import {mapActions} from 'vuex';

export default {
    props: {
        subscription: [Object],
        state: [Boolean]
    },
    data: () => ({
        sale: {
            trainer_id: -1,
            payment_type: 1,
            time_id: 1,
            hall_id: 1
        },
    }),
    methods: {
        ...mapActions({
            $createSale: 'createSale'
        }),
        async onSale () {
            const payload = {
                client_id: this.client.id,
                subscription_id: this.subscription.id,
                trainer_id: this.sale.trainer_id === -1 ? null : this.sale.trainer_id,
                price: this.subscription.price,
                payment_type: this.sale.payment_type,
                validity_visits: this.subscription.validity_visits,
                time_id: this.sale.time_id,
                hall_id: this.sale.hall_id,
            };
            try {
                this.$loading.enable();
                await this.$createSale(payload);
                this.$toast.success('Продажа успешно совершена!');
                this.$emit('cancel');
            } catch (e) {
                console.log(e);
            } finally {
                this.$loading.disable();
            }
        },
    },
    computed: {
        client () {
            return this.$store.getters.singleClient;
        },
        trainers () {
            return [{id: -1, name: '-Без тренера-'}, ...this.$store.getters.trainers];
        },
        payment_types () {
            return this.$store.getters.payment_types;
        }
    }
}
</script>

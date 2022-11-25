<template>
    <base-modal
        :state="state"
        :max-width="700"
        title="Редактирование купленного абонемента"
        @cancel="$emit('cancel')"
    >
        <template #default>
<!--            <v-date-picker
                label="Срок действия"
                v-model="currentSale.active_until"
            />-->
            <i-single-date-picker
                v-model="currentSale.active_until"
                :default-date="currentSale.active_until"
                label="Активен до"
            />
        </template>
        <template #actions>
            <v-btn text @click="$emit('cancel')">
                Отмена
            </v-btn>
            <v-spacer />
            <v-btn text color="success" @click="onSubmit">
                Сохранить <v-icon>mdi-check</v-icon>
            </v-btn>
        </template>
    </base-modal>
</template>

<script>
import {deepClone, reverseDate} from '@/utils/helpers';
import {mapActions} from 'vuex';

export default {
    props: {
        state: {
            type: Boolean,
            default: false,
        },
        sale: {
            type: Object,
            required: true
        }
    },
    data: () => ({
        currentSale: {},
    }),
    computed: {},
    methods: {
        ...mapActions({
            $updateSale: 'updateSale'
        }),
        async onSubmit () {
            try {
                this.$loading.enable();
                await this.$updateSale(this.currentSale);
                this.$toast.success('Абонемент успешно обновлен!');
                this.$emit('cancel');
            } catch (e) {
                this.$toast.error('Произошла ошибка!');
            } finally {
                this.$loading.disable();
            }
        }
    },
    watch: {
        state (value) {
            if (value) {
                this.currentSale = deepClone({
                    ...this.sale,
                    active_until: reverseDate(this.sale.active_until),
                })
            } else {
                this.currentSale = {};
            }
        }
    }
}
</script>

<style scoped lang="scss">

</style>

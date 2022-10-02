<template>
    <base-modal
        :state="state"
        title="Списание посещения"
        @cancel="$emit('cancel')"
    >
        <template #default>
            <v-select
                label="Тренер"
                v-model="trainerId"
                :items="trainers"
                item-value="id"
                item-text="name"
            />
        </template>
        <template #actions>
            <v-btn text @click="$emit('cancel')">
                Отмена
            </v-btn>
            <v-spacer />
            <v-btn color="success" @click="onSubmit">
                Списать <v-icon>mdi-check</v-icon>
            </v-btn>
        </template>
    </base-modal>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';

export default {
    data: () => ({
        trainerId: null,
    }),
    computed: {
        ...mapGetters({
            trainers: 'trainers'
        })
    },
    methods: {
        ...mapActions({
            $createVisit: 'createVisit',
        }),
        async onSubmit () {
            this.$loading.enable();
            await this.$createVisit({
                sale_id: this.sale.id,
                trainer_id: this.trainerId,
            });
            this.$toast.success('Абонемент успешно активирован!')
            this.$loading.disable();
            this.$emit('cancel');
        }
    },
    props: {
        state: Boolean,
        sale: [Object]
    },
    watch: {
        state (value) {
            if (value) {
                this.trainerId = this.sale.current_trainer.id;
            } else {
                this.trainerId = null;
            }
        }
    }
}
</script>

<style scoped lang="scss">

</style>

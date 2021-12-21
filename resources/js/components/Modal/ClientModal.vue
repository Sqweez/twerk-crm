<template>
    <v-dialog
        persistent
        max-width="1000"
        v-model="state"
    >
        <v-card>
            <v-card-title class="headline d-flex justify-space-between">
                <span class="white--text">{{ id === null ? 'Создать' : 'Редактировать' }} клиента:</span>
                <v-btn icon text class="float-right">
                    <v-icon color="white" @click="$emit('cancel')">
                        mdi-close
                    </v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-form>
                    <v-text-field
                        label="Имя"
                        v-model="client.name"
                    />
                    <v-text-field
                        label="Фамилия"
                        v-model="client.surname"
                    />
                    <v-text-field
                        id="client_phone"
                        label="Телефон"
                        v-model="client.phone"
                    />
                    <div class="d-flex align-center">
                        <v-text-field
                            style="max-width: 200px;"
                            v-model="client.pass_expired_at"
                            type="date"
                            label="Дата истечения абонемента"
                        >
                        </v-text-field>
                        <v-btn text @click="client.pass_expired_at = null;" class="ml-4">
                            Очистить дату
                        </v-btn>
                    </div>

                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-btn text @click="$emit('cancel')">Отмена</v-btn>
                <v-spacer></v-spacer>
                <v-progress-circular
                    v-if="loading"
                    indeterminate
                    color="primary"
                ></v-progress-circular>
                <v-btn text color="success" @click="onSubmit" v-else>
                    {{ id === null ? 'Создать' : 'Редактировать' }} клиента
                    <v-icon>mdi-check</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import InputMask from 'inputmask';
export default {
    data: () => ({
        client: {},
        loading: false,
        photo: null,
    }),
    mounted() {
        const phoneInput = document.getElementById('client_phone');
        if (phoneInput) {
            const inputMask = new InputMask("+7(999)999-99-99");
            inputMask.mask(phoneInput);
        }
    },
    methods: {
        async onSubmit() {
            this.loading = true;
            if(this.client.hasOwnProperty('id')) {
                await this.editClient();
            } else {
                await this.createClient();
            }
            this.$emit('cancel');
            this.loading = false;
        },
        async createClient() {
            await this.$store.dispatch('createClient', this.client);
            this.$toast.success('Клиент успешно добавлен');
            return this.client;
        },
        async editClient() {
            await this.$store.dispatch('editClient', this.client);
            this.$toast.success('Клиент успешно отредактирован');
            this.$emit('cancel')
        },
        modifyPhone(phone) {
            return phone.replace(/[-()]/gi, '');
        },
    },
    props: {
        state: {
            type: Boolean,
            default: false
        },
        id: {
            type: Number,
            default: null
        }
    },
    watch: {
        state() {
            this.client = {};
            if (this.id) {
                this.client = JSON.parse(JSON.stringify(this.$store.getters.client(this.id)));
            }
            if (this.state === true) {
                setTimeout(() => {
                    const phoneInput = document.getElementById('client_phone');
                    if (phoneInput) {
                        const inputMask = new InputMask("+7(999)999-99-99");
                        inputMask.mask(phoneInput);
                    }
                }, 500);
            }

        },
    },
}
</script>

<style>
.theme--dark input[type="date"]::-webkit-calendar-picker-indicator {
    background-color: #ccc;
}
</style>

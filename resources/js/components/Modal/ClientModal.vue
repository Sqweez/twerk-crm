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
                        <v-btn text @click="clearPassExpired" class="ml-4">
                            Очистить дату
                        </v-btn>
                    </div>
                    <div class="d-flex align-center">
                        <v-text-field
                            style="max-width: 200px;"
                            v-model="client.purchase_date"
                            type="date"
                            label="Дата покупки абонемента"
                        >
                        </v-text-field>
                        <v-btn text class="ml-4" @click="setToday(123);">
                            Сегодня
                        </v-btn>
                        <v-btn text @click="clearPurchaseDate" class="ml-4">
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
import moment from 'moment';
import InputMask from 'inputmask';

export default {
    data: () => ({
        client: {
            purchase_date: null,
        },
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
        setToday() {
            this.client.purchase_date = moment().format('yyyy-MM-D');
            this.$forceUpdate();
        },
        clearPurchaseDate() {
            this.client.purchase_date = null;
            this.$forceUpdate();
        },
        clearPassExpired() {
            this.client.pass_expired_at = null;
            this.$forceUpdate();
        },
        async onSubmit() {
            this.loading = true;
            if(this.client.hasOwnProperty('id')) {
                const client = await this.editClient();
                if (!client) {
                    this.loading = false;
                    return;
                }
            } else {
                const client = await this.createClient();
                if (!client) {
                    this.loading = false;
                    return;
                }
            }
            this.$emit('cancel');
            this.loading = false;
        },
        async createClient() {
            if (!this.client.name) {
                this.$toast.error('Заполните поле имя!');
                return false;
            }
            if (!this.client.surname) {
                this.$toast.error('Заполните поле фамилия!');
                return false;
            }
            if (!this.client.phone) {
                this.$toast.error('Заполните поле телефон!');
                return false;
            }
            await this.$store.dispatch('createClient', this.client);
            this.$toast.success('Клиент успешно добавлен');
            return this.client;
        },
        async editClient() {
            if (!this.client.name) {
                this.$toast.error('Заполните поле имя!');
                return false;
            }
            if (!this.client.surname) {
                this.$toast.error('Заполните поле фамилия!');
                return false;
            }
            if (!this.client.phone) {
                this.$toast.error('Заполните поле телефон!');
                return false;
            }
            await this.$store.dispatch('editClient', this.client);
            this.$toast.success('Клиент успешно отредактирован');
            this.$emit('cancel')
            return true;
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

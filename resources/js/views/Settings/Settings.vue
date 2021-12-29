<template>
    <v-card>
        <v-card-title>
            Системные настройки
        </v-card-title>
        <v-card-text>
            <v-textarea
                v-model="message"
                label="Сообщение для whatsapp"
            ></v-textarea>
            <p>Необходимо указать %ИМЯ%, в том месте куда нужно будет подставить имя клиента <br>Если подставлять имя не требуется, то %ИМЯ% не нужно</p>
            <p></p>
            <p>
                Результат:
                <b>{{ messageOutput }}</b>
            </p>
            <v-btn color="success" @click="saveSettings">
                Сохранить
            </v-btn>
        </v-card-text>
    </v-card>
</template>

<script>
import axiosClient from "../../utils/axiosClient";
import axios from "axios";

export default {
    data: () => ({
        message: '',
    }),
    async mounted() {
        const { data } = await axiosClient.get('/settings');
        this.message = data.data.whatsappMessage;
    },
    computed: {
        messageOutput() {
            return this.message.replace('%ИМЯ%', 'Иванов Иван')
        }
    },
    methods: {
        async saveSettings() {
            this.$loading.enable();
            const payload = {
                whatsappMessage: this.message
            };

            await axiosClient.post('/settings', payload);
            this.$loading.disable();
            this.$toast.success('Настройки сохранены');
        }
    },
}
</script>

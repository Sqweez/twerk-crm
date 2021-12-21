<template>
    <v-dialog
        persistent
        max-width="1000"
        v-model="state"
    >
        <v-card>
            <v-card-title class="headline d-flex justify-space-between">
                <span class="white--text">{{ id === null ? 'Создать' : 'Редактировать' }} админа:</span>
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
                        v-model="user.name"
                    />
                    <v-text-field
                        label="Логин"
                        v-model="user.login"
                    />
                    <v-text-field
                        label="Пароль"
                        v-model="user.password"
                    />
                    <p v-if="id">
                        Если пароль не нужно менять оставьте это поле пустым
                    </p>
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
                    {{ id === null ? 'Создать' : 'Редактировать' }} пользователя
                    <v-icon>mdi-check</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    data: () => ({
        user: {},
        loading: false,
    }),
    methods: {
        async onSubmit() {
            this.loading = true;
            if(this.user.hasOwnProperty('id')) {
                await this.editUser();
            } else {
                await this.createUser();
            }
            this.$emit('cancel');
            this.loading = false;
        },
        async createUser() {
            await this.$store.dispatch('createUser', this.user);
            this.$toast.success('Админ успешно добавлен');
            return this.client;
        },
        async editUser() {
            await this.$store.dispatch('editUser', this.user);
            this.$toast.success('Админ успешно отредактирован');
            this.$emit('cancel')
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
                this.user = JSON.parse(JSON.stringify(this.$store.getters.user(this.id)));
            }
        },
    },
}
</script>

<style>

</style>

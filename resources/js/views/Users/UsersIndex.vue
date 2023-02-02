<template>
    <div>
        <i-card-page title="Список пользователей">
            <div class="d-flex justify-space-between align-center">
                <v-btn color="error" @click="clientModal = true">Добавить пользователя <v-icon>mdi-plus</v-icon></v-btn>
            </div>
            <v-row>
                <v-col>
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
                        :page.sync="pagination.page"
                        :items="users"
                        @page-count="pageCount = $event"
                        :items-per-page="10"
                    >
                        <template v-slot:item.actions="{ item }">
                            <v-btn icon @click="userId = item.id; clientModal = true;">
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>
                            <v-btn icon @click="confirmationModal = true; userId = item.id;" v-if="$auth.id !== item.id">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                            <v-btn icon @click="$router.push(`users/${item.id}`)">
                                <v-icon>mdi-eye</v-icon>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
            <UserModal
                :state="clientModal"
                :id="userId"
                v-on:cancel="userId = null; clientModal = false;"
            />
            <ConfirmationModal
                :state="confirmationModal"
                :on-confirm="deleteUser"
                v-on:cancel="userId = null; confirmationModal = false"
                message="Вы действительно хотите удалить выбранного пользователя?" />
        </i-card-page>
    </div>
</template>

<script>
import ConfirmationModal from "@/components/Modal/ConfirmationModal";
    import UserModal from "../../components/Modal/UserModal";
import {mapActions} from 'vuex';

export default {
    components: {
        UserModal,
        ConfirmationModal,
    },
    async created() {
        this.$loading.enable();
        await this.$getUsers();
        this.$loading.disable();
    },
    methods: {
        ...mapActions({
            $getUsers: 'getUsers',
        }),
        async deleteUser() {
            this.$loading.enable();
            await this.$store.dispatch('deleteUser', this.userId);
            this.$loading.disable();
            this.$toast.success('Админ успешно удален из системы!');
            this.userId = null;
            this.confirmationModal = false;
        }
    },
    data: () => ({
        exportModal: false,
        confirmationModal: false,
        clientModal: false,
        userId: null,
        balanceModal: false,
        search: '',
        pagination: {
            ascending: true,
            rowsPerPage: 10,
            page: 1
        },
        pageCount: 1,
        headers: [
            {
                value: 'name',
                text: 'Имя',
                sortable: false
            },
            {
                value: 'login',
                text: 'Логин',
                sortable: false,
            },
            {
                value: 'string_role',
                text: 'Роль',
                sortable: false,
            },
            {
                value: 'actions',
                text: 'Действие'
            }
        ]
    }),
    computed: {
        users() {
            return this.$store.getters.users;
        }
    }
}
</script>

<style scoped>
th {
    font-size: 16px;
}
</style>

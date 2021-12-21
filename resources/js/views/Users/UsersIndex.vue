<template>
    <v-card>
        <v-card-title>Список клиентов</v-card-title>
        <v-card-text>
            <v-container>
                <div class="d-flex justify-space-between align-center">
                    <v-btn color="error" @click="clientModal = true">Добавить админа <v-icon>mdi-plus</v-icon></v-btn>
                </div>
                <v-row>
                    <v-col>
                        <v-text-field
                            class="mt-2"
                            v-model="search"
                            solo
                            clearable
                            label="Поиск админа"
                            single-line
                            hide-details
                        ></v-text-field>
                        <v-data-table
                            loading-text="Идет загрузка клиентов"
                            :search="search"
                            no-results-text="Нет результатов"
                            no-data-text="Нет данных"
                            :headers="headers"
                            :page.sync="pagination.page"
                            :items="users"
                            @page-count="pageCount = $event"
                            :items-per-page="10"
                            :footer-props="{
                            'items-per-page-options': [10, 15, {text: 'Все', value: -1}],
                            'items-per-page-text': 'Записей на странице',
                        }">
                            <template v-slot:item.actions="{ item }">
                                <v-btn icon @click="userId = item.id; clientModal = true;">
                                    <v-icon>mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn icon @click="confirmationModal = true; userId = item.id;" v-if="$auth.id !== item.id">
                                    <v-icon>mdi-delete</v-icon>
                                </v-btn>
                            </template>
                            <template slot="footer.page-text" slot-scope="{pageStart, pageStop, itemsLength}">
                                {{ pageStart }}-{{ pageStop }} из {{ itemsLength }}
                            </template>
                        </v-data-table>
                        <div class="text-xs-center pt-2">
                            <v-pagination
                                v-model="pagination.page"
                                :total-visible="10"
                                :length="pageCount"></v-pagination>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>
        <UserModal
            :state="clientModal"
            :id="userId"
            v-on:cancel="userId = null; clientModal = false;"
        />
        <ConfirmationModal
            :state="confirmationModal"
            :on-confirm="deleteUser"
            v-on:cancel="userId = null; confirmationModal = false"
            message="Вы действительно хотите удалить выбранного админа?" />
    </v-card>
</template>

<script>
import ConfirmationModal from "@/components/Modal/ConfirmationModal";
    import UserModal from "../../components/Modal/UserModal";

export default {
    components: {
        UserModal,
        ConfirmationModal,
    },
    async created() {
        await this.$store.dispatch('getUsers');
    },
    methods: {
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

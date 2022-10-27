<template>
    <v-card>
        <v-card-title>Список клиентов</v-card-title>
        <v-card-text>
            <div class="d-flex justify-space-between align-center">
                <v-btn color="error" @click="clientModal = true">Добавить клиента
                    <v-icon>mdi-plus</v-icon>
                </v-btn>
            </div>
            <v-text-field
                class="mt-2"
                v-model="search"
                solo
                clearable
                label="Поиск клиента"
                single-line
                hide-details
            ></v-text-field>
            <v-data-table
                :search="search"
                :headers="headers"
                :page.sync="pagination.page"
                :items="clients"
                @page-count="pageCount = $event"
                @current-items="getFilteredClients"
                :items-per-page="10"
                @click:row="$router.push(`/clients/${$event.id}`)"
            >
                <template v-slot:item.avatar="{item}">
                    <div v-if="item.avatar" class="d-flex mt-2 mb-4">
                        <div style="width: 200px; height: 200px;">
                            <img :src="item.avatar"
                                 style="width: 100%; height: 100%; object-fit: cover; object-position: top;"
                                 alt="Аватар">
                        </div>
                    </div>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-btn icon @click="clientId = item.id; clientModal = true;">
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                    <v-btn icon @click="confirmationModal = true; clientId = item.id;">
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                    <v-btn icon @click="$router.push(`/clients/${item.id}`)">
                        <v-icon>mdi-eye</v-icon>
                    </v-btn>
                </template>
                <template slot="footer.page-text" slot-scope="{pageStart, pageStop, itemsLength}">
                    {{ pageStart }}-{{ pageStop }} из {{ itemsLength }}
                </template>
            </v-data-table>
        </v-card-text>
        <ClientModal
            :state="clientModal"
            :id="clientId"
            @cancel="clientId = null; clientModal = false;"
        />
        <ConfirmationModal
            :state="confirmationModal"
            :on-confirm="deleteUser"
            @cancel="clientId = null; confirmationModal = false"
            message="Вы действительно хотите удалить выбранного клиента?"
        />
    </v-card>
</template>

<script>
import ConfirmationModal from "@/components/Modal/ConfirmationModal";
import ClientModal from "@/components/Modal/ClientModal";

export default {
    components: {
        ClientModal,
        ConfirmationModal,
    },
    async created() {
        await this.$store.dispatch('getClients');
    },
    methods: {
        async deleteUser() {
            this.$loading.enable();
            await this.$store.dispatch('deleteClient', this.clientId);
            this.$loading.disable();
            this.$toast.success('Клиент успешно удален из системы!');
            this.userId = null;
            this.confirmationModal = false;
        },
        getFilteredClients (clients) {
            if (clients.length === 1 && clients[0].pass === this.search) {
                this.$router.push(`/clients/${clients[0].id}`)
            }
        },
    },
    data: () => ({
        exportModal: false,
        confirmationModal: false,
        clientModal: false,
        clientId: null,
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
                value: 'phone',
                text: 'Телефон',
                sortable: false,
            },
            {
                value: 'pass',
                text: 'Номер карты',
                sortable: false,
            },
           /* {
                value: 'avatar',
                text: 'Фото',
                sortable: false,
            },*/
          /*  {
                value: 'actions',
                text: 'Действие'
            }*/
        ]
    }),
    computed: {
        clients() {
            return this.$store.getters.clients;
        }
    }
}
</script>

<style scoped>
th {
    font-size: 16px;
}
</style>

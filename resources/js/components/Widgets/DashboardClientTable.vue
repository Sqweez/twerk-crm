<template>
    <v-card>
        <v-card-title>
            {{ title }}
        </v-card-title>
        <v-card-text>
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
                loading-text="Идет загрузка клиентов"
                :search="search"
                no-results-text="Нет результатов"
                no-data-text="Нет данных"
                :headers="headers"
                :page.sync="pagination.page"
                :items="clients"
                @page-count="pageCount = $event"
                :items-per-page="10"
                :footer-props="{
                            'items-per-page-options': [10, 15, {text: 'Все', value: -1}],
                            'items-per-page-text': 'Записей на странице',
                        }">
                <template v-slot:item.actions="{ item }">
                    <v-btn icon @click="onSend(item)" color="success">
                        <v-icon>mdi-whatsapp</v-icon>
                    </v-btn>
                </template>
                <template slot="footer.page-text" slot-scope="{pageStart, pageStop, itemsLength}">
                    {{ pageStart }}-{{ pageStop }} из {{ itemsLength }}
                </template>
            </v-data-table>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    props: {
        clients: {
            type: Array,
            default: () => ([])
        },
        title: {
            type: 'String',
            default: 'Клиенты'
        },
        onSend: {
            type: Function,
            required: true,
        }
    },
    data: () => ({
        search: '',
        pagination: {
            ascending: true,
            rowsPerPage: 10,
            page: 1
        },
        pageCount: 1,
        headers: [
            {
                value: 'client_name',
                text: 'Имя',
                sortable: false
            },
            {
                value: 'phone',
                text: 'Телефон',
                sortable: false,
            },
            {
                value: 'expire_date',
                text: 'Дата истечения абонемента',
                sortable: true,
            },
            {
                value: 'actions',
                text: 'Написать'
            }
        ]
    })
}
</script>

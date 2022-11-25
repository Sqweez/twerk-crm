<template>
    <v-row>
        <v-col
            cols="12"
            sm="6"
            md="4"
        >
            <v-menu
                ref="menu"
                v-model="menu"
                :close-on-content-click="false"
                :return-value.sync="date"
                transition="scale-transition"
                offset-y
                min-width="auto"
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                        v-model="date"
                        :label="label"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                    ></v-text-field>
                </template>
                <v-date-picker
                    v-model="date"
                    no-title
                    scrollable
                >
                    <v-spacer></v-spacer>
                    <v-btn
                        text
                        color="primary"
                        @click="menu = false"
                    >
                        Отмена
                    </v-btn>
                    <v-btn
                        text
                        color="primary"
                        @click="onSave"
                    >
                        OK
                    </v-btn>
                </v-date-picker>
            </v-menu>
        </v-col>
    </v-row>
</template>

<script>
export default {
    props: {
        defaultDate: {
            type: String,
            default: null,
        },
        label: {
            type: String,
            default: 'Дата:'
        }
    },
    beforeMount() {
        this.date = this.defaultDate;
    },
    data: () => ({
        menu: false,
        date: null,
    }),
    methods: {
        onSave () {
            this.$refs.menu.save(this.date);
            this.$emit('input', this.date);
        }
    },
}
</script>

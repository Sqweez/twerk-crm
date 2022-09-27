<template>
    <div>
        <v-card>
            <v-card-title v-if="!noTitle">
                {{ title }}
            </v-card-title>
            <v-card-text>
                <slot />
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    data: () => ({}),
    computed: {},
    methods: {},
    props: {
        title: {
            type: String,
            default: 'Страница'
        },
        noTitle: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style scoped lang="scss">

</style>

<template>
    <v-overlay :value="IS_LOADING_STATE">
        <v-progress-circular
            indeterminate
            size="64"
            color="danger" />
    </v-overlay>
</template>

<script>
    export default {
        data: () => ({}),
        methods: {},
    }
</script>

<style scoped>

</style>

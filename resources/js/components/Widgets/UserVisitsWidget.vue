<template>
    <div>
        <i-card-page title="Журнал посещений">
            <user-visits-history :user-id="$auth.id"/>
        </i-card-page>
    </div>
</template>

<script>
import UserVisitsHistory from '@/components/Users/UserVisitsHistory';
export default {
    components: {UserVisitsHistory},
    data: () => ({}),
    computed: {},
    methods: {}
}
</script>

<style scoped lang="scss">

</style>

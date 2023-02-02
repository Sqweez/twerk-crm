<template>
    <div>
        <i-card-page title="Сведения о сотруднике">
            <v-row>
                <v-col cols="12" xl="6">
                    <v-tabs v-model="tab">
                        <v-tab>
                            Активные абонементы
                        </v-tab>
                    </v-tabs>
                </v-col>
            </v-row>
            <v-tabs-items v-model="tab">
                <v-tab-item>
                    <active-subscriptions :user-id="$route.params.id" />
                </v-tab-item>
            </v-tabs-items>
        </i-card-page>
    </div>
</template>

<script>
import ActiveSubscriptions from '@/components/Users/ActiveSubscriptions';
export default {
    components: {ActiveSubscriptions},
    data: () => ({
        tab: null,
    }),
    computed: {},
    methods: {}
}
</script>

<style scoped lang="scss">

</style>

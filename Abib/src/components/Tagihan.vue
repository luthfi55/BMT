<template>
    <v-container>
        <div class="v-application__wrap">
            <v-card title="Tagihan" subtitle="Rp 500.000" variant="tonal">
                <v-card-actions>
                    <router-link to="/payment"><v-btn class="text-red-500" color="#5865f2"
                            variant="flat">Bayar</v-btn></router-link>
                </v-card-actions>
            </v-card>
        </div>
        
    </v-container>
    <router-view></router-view>
</template>

<style scoped>
.v-application__wrap {
    min-height: 0vh !important;
}
</style>
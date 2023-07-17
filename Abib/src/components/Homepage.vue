<template>
    <v-card>
        <div class="tab">
            <v-tabs v-model="tab" bg-color="primary">
                <div class="v-slide-group__content">
                    <div>
                        <v-tab value="one">Saldo</v-tab>
                        <v-tab value="two">Tagihan</v-tab>
                        <v-tab value="three">Tabungan</v-tab>
                    </div>


                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-btn color="blue-lighten-5" v-bind="props"> Profile </v-btn>
                        </template>
                        <v-list>
                            <v-list-item v-for="(item, index) in items" :key="index" :value="index">
                                <v-list-item-title>{{ item.title }}</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </div>

            </v-tabs>
        </div>


        <v-card-text>
            <v-window v-model="tab">
                <v-window-item value="one">
                    <Saldo />
                </v-window-item>

                <v-window-item value="two">
                    <Tagihan />
                    <Tagihan />
                    <Tagihan />
                </v-window-item>

                <v-window-item value="three">
                    <Tabungan />
                </v-window-item>
            </v-window>
        </v-card-text>
    </v-card>

    <!-- <Footer /> -->
</template>
  
<script>
export default {
    data: () => ({
        tab: null,
        items: [
            { title: 'Logout'},
        ],
    }),

}
</script>
<script setup>
import Saldo from '@/components/Saldo.vue'
import Tabungan from '@/components/Tabungan.vue'
import Tagihan from '@/components/Tagihan.vue'
// import Footer from '@/components/Footer.vue'
// import Icons from '@/components/Icons.vue'
</script>

<style scoped>
.tab {
    border-radius: 0;
}
div.v-slide-group__content {
    justify-content: space-around;
    align-items: center;
}
</style>
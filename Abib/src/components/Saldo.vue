<template>
    <v-container>
        <div id="card-balance" class="v-application__wrap">
            <v-card title="Saldo Pengguna" subtitle='Rp ******' variant="tonal">
                <v-card-actions>
                        <v-dialog v-model="dialog" persistent width="768">
                            <template v-slot:activator="{ props }">
                                <v-btn class="text-red-500" color="#5865f2" variant="flat" v-bind="props"> Open Dialog </v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                    <span class="text-h5">Masukkan Pin Anggota</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field label="Pin*" type="password" required></v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                    <small>*indicates required field</small>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue-darken-1" variant="text" @click="dialog = false">
                                        Close
                                    </v-btn>
                                    <v-btn color="blue-darken-1" variant="text" @click="dialog = false">
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    

                </v-card-actions>
            </v-card>
        </div>
    </v-container>
</template>

<style scoped>
.v-application__wrap {
    min-height: 0vh !important;
}
</style>

<script>
export default {
    data: () => {
        return {
            balance: 'Rp 250.000',
            dialog: false
        }
    },
    methods: {
        showbalance() {
            let text = document.getElementById('card-balance').innerHTML;
            document.getElementById('card-balance').innerHTML = text.replace("Rp ******", "Rp 250.000");
        }
    }
    // mounted() {
    //         function showbalance() {

    //         }
    // }

}
</script>
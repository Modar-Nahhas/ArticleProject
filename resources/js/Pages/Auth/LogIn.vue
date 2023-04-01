<template>
    <v-container style="height: 100%" class="d-flex justify-center align-center w-50">
        <v-form @submit.prevent="login" ref="loginForm">
            <v-row no-gutters dense class="p-5">
                <v-col cols="12">
                    <p class="text-center">Please log in</p>
                </v-col>
                <v-col cols="12">
                    <v-text-field v-model.trim="credentials.name" outlined label="Name"></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field v-model="credentials.password" outlined type="password"
                                  label="Password"></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-btn :disabled="submitting" type="submit" class="w-100" color="primary">Signin</v-btn>
                </v-col>
            </v-row>
        </v-form>
    </v-container>
</template>

<script>

import router from "@/Plugins/router";

export default {
    name: "LogIn",
    data() {
        return {
            credentials: {
                name: 'admin',
                password: '12345'
            },
            submitting: false
        }
    },
    methods: {
        async login() {
            this.submitting = true;
            this.showProgress();
            let res = await login();
            this.showProgress(false);
            this.showNotification(res);
            if (res.result && res.code == 200) {
                router.push({name: 'home'});
            }else{
                this.submitting = false;
            }

        }
    }
}
</script>

<style scoped>

</style>

<template>
    <v-app app>
        <v-progress-linear v-if="$store.getters.showProgress" indeterminate></v-progress-linear>
        <notifications group="public" position="center"/>
        <template v-if="$store.state.isSignedIn">
            <v-app-bar
                absolute
            >
                <v-app-bar-nav-icon @click="showDrawer = !showDrawer"></v-app-bar-nav-icon>

                <v-toolbar-title>Articles Website</v-toolbar-title>

                <v-spacer></v-spacer>

            </v-app-bar>
            <v-navigation-drawer
                v-model="showDrawer"
                absolute
                temporary

            >
                <v-list-item>
                    <v-list-item-avatar>
                        <v-img src="https://randomuser.me/api/portraits/men/78.jpg"></v-img>
                    </v-list-item-avatar>

                    <v-list-item-content>
                        <v-list-item-title>{{ $store.getters.user.name }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-divider></v-divider>

                <v-list dense>
                    <v-list-item
                        v-for="link in links"
                        :key="link.title"
                        link
                        :to="link.link"
                    >
                        <v-list-item-icon>
                            <v-icon>{{ link.icon }}</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>{{ link.title }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

            </v-navigation-drawer>
            <v-main>
                <v-container>
                    <router-view></router-view>
                </v-container>

            </v-main>
        </template>
        <log-in v-else></log-in>
    </v-app>
</template>

<script>
import Home from "@/Pages/Home.vue";
import LogIn from "@/Pages/Auth/LogIn.vue";

export default {
    name: "App",
    components: {LogIn, Home},
    data() {
        return {
            showDrawer: false,
            showProgress:false,
            links: [
                {
                    title: 'Users',
                    icon: 'mdi-account-group-outline',
                    link: {name: 'articles'}
                },
                {
                    title: 'Articles',
                    icon: 'mdi-post-outline',
                    link: {name: 'articles'}
                },
            ]
        }
    },
    created() {
    }
}
</script>

<style scoped>

</style>

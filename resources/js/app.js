import './bootstrap';
import Vue from 'vue';

import vuetify from "@/Plugins/vuetify";
import store from "@/Plugins/store";
import router from "@/Plugins/router";
import Notification from "vue-notification";

import Helpers from "@/Mixin/Helpers.vue";
import App from "@/App.vue";

Vue.use(Helpers)
Vue.use(Notification);


const app = new Vue({
    vuetify,
    router,
    store: store,
    el: '#app',
    render: h => h(App),
});



import Vue from "vue";
import VueRouter from "vue-router";
import LogIn from "@/Pages/Auth/LogIn.vue";
import store from "@/Plugins/store";
import Home from "@/Pages/Home.vue";
import ArticleIndex from "@/Pages/Article/Index.vue";
import UserIndex from "@/Pages/User/Index.vue";

Vue.use(VueRouter);

const routes = [
    {
        path: '/login',
        name: 'login',
        component: LogIn,
        meta: {
            requiredAuth: false
        }
    },
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            requiredAuth: true,
        }
    },
    {
        path:'/articles',
        name:'articles',
        component: ArticleIndex,
        meta: {
            requiredAuth: true,
            permissions:[
                'view_articles'
            ],
        }
    }

]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

router.beforeEach((to, from, next) => {
    console.log(to)
    if (to.meta.requireAuth && !store.state.isSignedIn) {
        next({name: 'login'})
    }
})
export default router;

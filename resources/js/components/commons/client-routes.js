import Vue from "vue";
import VueRouter from "vue-router";
import index  from "@/js/components/client/home.vue";

import notAuthorized from "@/js/components/notAuthorized.vue";
Vue.use(VueRouter);


const adminRoutes = [ 
]
const router = new VueRouter({
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
    mode: "history",
    routes: [
        {
            path: "/",
            name: "index",
            component: index
        },
        {
            path: "/not-authorized",
            name: "notAuthorized",
            component: notAuthorized
        },
    ]
});

export default router;
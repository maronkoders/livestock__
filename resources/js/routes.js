import Vue from "vue";
import VueRouter from "vue-router";
import home from "@/js/components/dashboard/dashboard.vue";
import index  from "@/js/components/client/home.vue";
import industries from "@/js/components/dashboard/industries.vue";
import companies from "@/js/components/dashboard/companies.vue";
import skus from "@/js/components/dashboard/skus.vue";
import manufacturers from "@/js/components/dashboard/manufacturers.vue";
import productCategories from "@/js/components/dashboard/categories.vue";
import products from "@/js/components/dashboard/products.vue";
import subscribers from "@/js/components/dashboard/subscribers.vue";
import notAuthorized from "@/js/components/notAuthorized.vue";
import store from  "@/js/storeEvent.js";

Vue.use(VueRouter);
const workerRoutes = 
[
    "/home",
    "/products",
    "/subscribers",
    "/product-categories",
    "/industries",
    "/companies",
    "/manufacturers",
    "/skus"
];

const router = new VueRouter({
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
    mode: "history",
    routes: [{
            path: "/home",
            name: "home",
            component: home
        },
        {
            path: "/",
            name: "index",
            component: index
        },
        {
            path: "/product-categories",
            name: "productCategories",
            component: productCategories
        },
        {
            path: "/subscribers",
            name: "subscribers",
            component: subscribers
        },
        {
            path: "/skus",
            name: "skus",
            component: skus
        },
        {
            path: "/products",
            name: "products",
            component: products
        },
        {
            path: "/industries",
            name: "industries",
            component: industries
        },
        {
            path: "/companies",
            name: "companies",
            component: companies
        },
        {
            path: "/manufacturers",
            name: "manufacturers",
            component: manufacturers
        },
        {
            path: "/not-authorized",
            name: "notAuthorized",
            component: notAuthorized
        },
    ]
});

router.beforeEach((to, from, next) => {    
    if(store.state.loggedInUserType.role === "isWorker")
    {
        return (Object.values(workerRoutes).includes(to.matched[0].path))?next():router.push("/not-authorized");
    }else{
        return next();
    }
})

export default router;
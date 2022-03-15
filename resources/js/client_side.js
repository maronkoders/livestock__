window.Vue = require("vue");
import Routes from "../js/components/commons/client-routes";

Vue.component("home", require("./components/client/home.vue").default);
const app = new Vue({
    el: "#clientSide",
    router: Routes
});
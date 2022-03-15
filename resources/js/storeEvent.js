import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";
Vue.use(Vuex);
Vue.config.devtools = true

const storeEvent = new Vuex.Store({
    plugins: [createPersistedState()],
    state: {
        loggedInUserType:"",
        categories:[],
        industries:[],
        companies:[],
        defaultCompany :"",
        selectedCategorySku:"",
    },
    mutations: {
        putDefaultCompany(state, payload)
        {
            state.defaultCompany  = payload;
        },
        putCategories(state, payload)
        {
            state.categories  = payload;
        },
        putIndustries(state, payload)
        {
            state.industries  = payload;
        },
        putCompanies(state, payload)
        {
            state.companies  = payload;
        },
        putLoggedInUser(state, payload)
        {
            state.loggedInUserType =payload
        },
        putSelectedCategorySku(state , payload)
        {
            state.selectedCategorySku =payload;
        }
    }
});
export default storeEvent;
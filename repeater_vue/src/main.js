//import { createApp } from 'vue'
import * as Vue from 'vue'
import App from './App.vue'
import store from './store/index.js'
import router from './router'
//import date from "./functions/time/dates.js";
//mport { http } from './plugins/axios.js'


const app = Vue.createApp(App)
app.use(store)
app.use(router)
app.mount('#app')







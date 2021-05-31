//import { createApp } from 'vue'
import * as Vue from 'vue'
import App from './App.vue'
import store from './store/index.js'
import router from './router'
//mport { http } from './plugins/axios.js'


const app = Vue.createApp(App)
//app.use({http})
app.use(store)
app.use(router)
app.mount('#app')







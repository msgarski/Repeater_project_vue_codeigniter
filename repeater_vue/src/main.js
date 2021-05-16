import { createApp } from 'vue'
//import Vue from 'vue'
import App from './App.vue'
import {createRouter, createWebHistory} from "vue-router"
import SignIn from './components/authentication/SignIn.vue'
import SignUp from './components/newUser/SignUp.vue'
import HelloSite from './components/HelloSite.vue'
import ForgotPass from './components/authentication/ForgotPass.vue'
//import axios from 'axios'
//import { http } from './plugins/axios.js'


const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/signin', component: SignIn },
        { path: '/signup', component: SignUp },
        { path: '/'      , component: HelloSite },
        { path: '/forgot', component: ForgotPass }
    ]
});

// const http = axios.create({
//     baseURL: "http://localhost:8080/restapi",
//     headers: {
//         "Content-Type": "application/x-www-form-urlencoded",
//         "X-Requested-With": "XMLHttpRequest"
//     }
// });
//console.log(http)

const app = createApp(App)
//Vue.config.devtools = true
app.use(router)
app.mount('#app')

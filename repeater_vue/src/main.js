import { createApp } from 'vue'
import App from './App.vue'
import {createRouter, createWebHistory} from "vue-router"
import SignIn from './components/authentication/SignIn.vue'
import SignUp from './components/newUser/SignUp.vue'
import HelloSite from './components/HelloSite.vue'
import ForgotPass from './components/authentication/ForgotPass.vue'

//import { http } from "./plugins/axios.js"

//const ci4Url = 'http://repeater.localhost/'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/signin', component: SignIn },
        { path: '/signup', component: SignUp },
        { path: '/'      , component: HelloSite },
        { path: '/forgot', component: ForgotPass }
    ]
});

const app = createApp(App)

//app.use(http) 

app.use(router)

app.mount('#app')

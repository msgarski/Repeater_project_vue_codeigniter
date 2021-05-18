import { createRouter, createWebHashHistory } from 'vue-router'

import SignIn     from '../components/authentication/SignIn.vue'
import SignUp     from '../components/newUser/SignUp.vue'
import ForgotPass from '../components/authentication/ForgotPass.vue'
import HelloSite  from '../components/HelloSite.vue'


const routes = [
  { path: '/signin', component: SignIn },
  { path: '/signup', component: SignUp },
  { path: '/forgot', component: ForgotPass },
  { path: '/',       component: HelloSite }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
});

export default router

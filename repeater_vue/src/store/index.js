import { createStore } from 'vuex'

import router from '../router';
//import Vuex from 'vuex'

export default createStore({
  state: {
    isLoggedIn: false,
  },
  mutations: {
    login(state){
      state.isLoggedIn = true;
      router.push("/")
    },
    logout(state){
      state.isLoggedIn = false;
      localStorage.removeItem("token");
      localStorage.removeItem("expires");

      router.push('/');
    }
  },
  actions: {
    login({commit}, expires_in){
      setTimeout(()=>{commit('logout');}, expires_in);
      commit('login');
    },
    logout({commit}){
      commit('logout');
    },
  },
  modules: {
  },
  getters: {
    logInState(state){
      return state.isLoggedIn
    }

  }
})

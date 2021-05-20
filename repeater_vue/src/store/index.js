import { createStore } from 'vuex'
import router from '../router';

export default createStore({
  modules: {

  },
  state: {
    isLoggedIn: false,
    userId: null,
    cos: 'proba stora'
  },
  mutations: {
    login(state){
      state.isLoggedIn = true;
      router.push("/porch")
    },
    logout(state){
      state.isLoggedIn = false;
      localStorage.removeItem("token");
      localStorage.removeItem("expires");
      router.push('/');
    },
    setUserId(state, id){
      state.userId = id;
    },
  },
  actions: {
    login({commit}, expires_in){
      commit('login');
    },
    logout({commit}){
      commit('logout');
    },
    setUserId({commit}, id){
      localStorage.setItem('userId', id)
      commit('setUserId', id)
    }
  },
  getters: {
    logInState(state){
      return state.isLoggedIn
    },
    getUserId(state){
      return state.userId;
    }
  },

})

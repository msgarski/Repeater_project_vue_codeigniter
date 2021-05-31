import { createStore } from 'vuex'
//import router from '../router';
import rootMutations from './mutations.js';
import rootActions from './actions.js';
import rootGetters from './getters.js';

import optionsModule from './options/index.js'

export default createStore({
  modules: {
    option    :   optionsModule
  },
  state: {
    isLoggedIn: false,
    userId: null,
    cos: 'proba stora'
  },
  mutations :   rootMutations,
  actions   :   rootActions,
  getters   :   rootGetters
})

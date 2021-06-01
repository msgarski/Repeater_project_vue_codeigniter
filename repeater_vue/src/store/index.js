import { createStore } from 'vuex'
//import router from '../router';
import rootMutations from './mutations.js';
import rootActions from './actions.js';
import rootGetters from './getters.js';

import optionsModule from './options/index.js'
import learningModule from './learning/index.js'

export default createStore({
  modules: {
    option    :   optionsModule,
    learning  :   learningModule
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

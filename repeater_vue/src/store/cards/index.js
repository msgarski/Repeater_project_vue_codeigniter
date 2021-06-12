import cardsMutations from './mutations.js';
import cardsActions from './actions.js';
import cardsGetters from './getters.js';

export default {
    namespaced: true,
    state(){
        return {
            name: 'Robert', // to na próbę...
            currCard  :   null

        };
    },
    mutations   :   cardsMutations,
    actions     :   cardsActions,
    getters     :   cardsGetters

}
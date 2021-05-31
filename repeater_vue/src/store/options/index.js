import optionsMutations from './mutations.js';
import optionsActions from './actions.js';
import optionsGetters from './getters.js';

export default {
    namespaced: true,
    state(){
        return {
            name: 'Robert', // to na próbę...
            learningBatchLimit  :   10,
            learningDayLimit    :   20,
            repeatDayLimit      :   30, 
            overlearning        :   true,

        };
    },
    mutations   :   optionsMutations,
    actions     :   optionsActions,
    getters     :   optionsGetters

}
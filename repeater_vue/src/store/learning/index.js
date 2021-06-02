import learningMutations from './mutations.js';
import learningActions from './actions.js';
import learningGetters from './getters.js';

export default {
    namespaced: true,
    state(){
        return {
            learningBatchLimit  :   10,
            batchForLearning    :   null,
            loopNumber          :   1
        };
    },
    mutations   :   learningMutations,
    actions     :   learningActions,
    getters     :   learningGetters

}
import repeatingMutations from './mutations.js';
import repeatingActions from './actions.js';
import repeatingGetters from './getters.js';

export default {
    namespaced: true,
    state(){
        return {
            repeatsForCourses       :   null,
            repeatingBatchLimit     :   10,
            chosenCourse            :   null,
            batchForRepeating       :   null, // array of words for learning from db
            loopNumber              :   1,
            index                   :   0,
            endRepeating            :   false
        };
    },
    mutations   :   repeatingMutations,
    actions     :   repeatingActions,
    getters     :   repeatingGetters

}
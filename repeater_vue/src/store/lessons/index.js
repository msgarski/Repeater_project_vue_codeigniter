import lessonsMutations from './mutations.js';
import lessonsActions from './actions.js';
import lessonsGetters from './getters.js';

export default {
    namespaced: true,
    state(){
        return {
            name: 'Robert', // to na próbę...
            allLessons  :   null

        };
    },
    mutations   :   lessonsMutations,
    actions     :   lessonsActions,
    getters     :   lessonsGetters

}
import coursesMutations from './mutations.js';
import coursesActions from './actions.js';
import coursesGetters from './getters.js';

export default {
    namespaced: true,
    state(){
        return {
            name: 'Robert', // to na próbę...
            allCourses  :   null

        };
    },
    mutations   :   coursesMutations,
    actions     :   coursesActions,
    getters     :   coursesGetters

}
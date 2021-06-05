export default {
    setUserName({commit}, name){
        commit('setUserName', name);
    },
    setAllLessons({commit}, courses){
        commit('setAllLessons', courses);
    }
};

export default {
    setUserName({commit}, name){
        commit('setUserName', name);
    },
    setAllCourses({commit}, courses){
        commit('setAllCourses', courses);
    }
};

export default {
    setRepeatingBatchLimit({commit}, limit){
        commit('setRepeatingBatchLimit', limit);
    },
    setBatchForRepeating({commit}, payload)
    {
        commit('setBatchForRepeating', payload);
    },
    increaseLoopNumber({commit})
    {
        commit('increaseLoopNumber');
    },
    resetLoopNumber({commit})
    {
        commit('resetLoopNumber')
    },
    setIndex({commit}, payload)
    {
        commit('setIndex', payload);
    },
    setEndRepeating({commit}, payload)
    {
        commit('setEndRepeating', payload);
    },
    setChosenCourse({commit}, payload)
    {
        commit('setChosenCourse', payload);
    },
    setRepeatsForCourses({commit}, payload)
    {
        commit('setRepeatsForCourses', payload);
    }
};

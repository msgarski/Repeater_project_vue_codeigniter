export default {
    setLearningBatchLimit({commit}, limit){
        commit('setLearningBatchLimit', limit);
    },
    setBatchForLearning({commit}, payload)
    {
        commit('setBatchForLearning', payload);
    },
    increaseLoopNumber({commit})
    {
        commit('increaseLoopNumber');
    },
    resetLoopNumber({commit})
    {
        commit('resetLoopNumber')
    }
};

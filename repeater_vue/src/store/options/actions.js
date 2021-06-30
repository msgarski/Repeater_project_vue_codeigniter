export default {
    setUserName({commit}, name){
        commit('setUserName', name);
    },
    setLearningBatchLimit({commit}, limit){
        commit('setLearningBatchLimit', limit);
    },
    setLearningDayLimit({commit}, limit){
        commit('setLearningDayLimit', limit);
    },
    setOverlearning({commit}, isOrNot){
        commit('setOverlearning', isOrNot);
    },
    setRepeatDayLimit({commit}, limit){
        commit('setRepeatDayLimit', limit);
    },
    setFastRepeatBatch({commit}, limit){
        commit('setFastRepeatBatch', limit);
    }
};

export default {
    setUserName(state, name){
        state.name = name;
    },
    setLearningBatchLimit(state, limit){
        state.learningBatchLimit = limit;
    },
    setLearningDayLimit(state, limit){
        state.learningDayLimit = limit;
    },
    setOverlearning(state, isOrNot){
        state.overlearning = isOrNot;
    },
    setRepeatDayLimit(state, limit){
        state.repeatDayLimit = limit;
    }
};


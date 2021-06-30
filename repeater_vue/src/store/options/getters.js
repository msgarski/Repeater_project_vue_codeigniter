export default {
    getUserName(state){
        return state.name;
    },
    getLearningBatchLimit(state){
        return state.learningBatchLimit;
    },
    getLearningDayLimit(state){
        return state.learningDayLimit;
    },
    getOverlearning(state){
        return state.overlearning;
    },
    getRepeatDayLimit(state){
        return state.repeatDayLimit;
    },
    getFastRepeatBatch(state){
        return state.fastRepeatBatch;
    }
};
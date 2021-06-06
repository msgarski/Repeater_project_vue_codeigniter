export default {
    getRepeatingBatchLimit(state){
        return state.repeatingBatchLimit;
    },
    getBatchForRepeating(state)
    {
        return state.batchForLearning;
    },
    getWordForRepeating(state)
    {
        return state.batchForLearning;
    },
    getLoopNumber(state)
    {
        return state.loopNumber;
    },
    getIndex(state)
    {
        return state.index;
    },
    getEndRepeating(state)
    {
        return state.endLearning;
    },
    getRepeatsForCourses(state)
    {
        return state.repeatsForCourses;
    }
};
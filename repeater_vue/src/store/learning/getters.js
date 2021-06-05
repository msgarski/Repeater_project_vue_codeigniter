export default {
    getLearningBatchLimit(state){
        return state.learningBatchLimit;
    },
    getBatchForLearning(state)
    {
        return state.batchForLearning;
    },
    getWordForLearning(state)
    {
        return state.batchForLearning;
    },
    getTodoById: (state) => (id) => {
        return state.batchForLearning.find(batchForLearning => batchForLearning.id === id);
    },
    getLoopNumber(state)
    {
        return state.loopNumber;
    },
    getIndex(state)
    {
        return state.index;
    },
    getEndLearning(state)
    {
        return state.endLearning;
    }
};
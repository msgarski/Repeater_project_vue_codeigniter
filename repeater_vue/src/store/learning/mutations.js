export default {
    setLearningBatchLimit(state, limit){
        state.learningBatchLimit = limit;
    },
    setBatchForLearning(state, payload)
    {
        state.batchForLearning = payload;
    },
    increaseLoopNumber(state)
    {
        state.loopNumber += 1
    },
    resetLoopNumber(state)
    {
        state.loopNumber = 1;
    }
    
};


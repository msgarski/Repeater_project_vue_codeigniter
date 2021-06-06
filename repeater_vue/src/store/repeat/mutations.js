export default {
    setRepeatingBatchLimit(state, limit){
        state.repeatingBatchLimit = limit;
    },
    setBatchForRepeating(state, payload)
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
    },
    setIndex(state, payload)
    {
        state.index = payload;
    },
    setEndRepeating(state, payload)
    {
        state.endLearning = payload;
    },
    setChosenCourse(state, payload)
    {
        state.chosenCourse = payload;
    },
    setRepeatsForCourses(state, payload)
    {
        state.repeatsForCourses = payload;
    }
    
};


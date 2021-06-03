export default {
    logInState(state){
        return state.isLoggedIn
    },
    getUserId(state){
        return state.userId;
    },
    getTodayDate(state){
        return state.todayDate;
    },
    getPeriodForEasyWord(state){
        return state.periodForEasyWord;
    },
    getMaxNumTries(state){
        return state.maxNumTries;
    }



};
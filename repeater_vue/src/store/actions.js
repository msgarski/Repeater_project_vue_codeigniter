export default {
    login({commit}, expires_in){
        commit('login');
    },
    logout({commit}){
        commit('logout');
    },
    setUserId({commit}, id){
        localStorage.setItem('userId', id)
        commit('setUserId', id)
    },
    setTodayDate({commit}){
        commit('setTodayDate');
    }



};
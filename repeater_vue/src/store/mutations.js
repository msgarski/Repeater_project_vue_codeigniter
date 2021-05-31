import router from '../router';


export default {
    login(state){
        state.isLoggedIn = true;
        router.push("/porch")
    },
    logout(state){
        state.isLoggedIn = false;
        localStorage.removeItem("token");
        localStorage.removeItem("expires");
        router.push('/');
    },
    setUserId(state, id){
        state.userId = id;
    },



};
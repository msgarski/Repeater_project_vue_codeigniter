<template>
    <h1>Logowanie</h1>

    <form @submit.prevent="authorization">
        <div>
            <label for="email" >email</label>
            <input type="email" name="email" id="email" v-model.trim="email">
            </div>

            <div>
            <label for="password">Password</label>
            <input type="password" name="password" v-model.trim="password">
        </div>

                <button>Zatwierdź</button>

    </form>
    <div>
        
    </div>
    <div>
        <router-link to="/">Wyjście</router-link>
    
        <router-link to="/forgot">Zapomniane hasło...</router-link>
    </div>
    

</template>

<script>
import http from '../../plugins/axios.js'

export default {
    name: 'SignIn',
    data(){
        return {
            'email': '',
            'password': '',
            'expires_in': '',
            'token': '',
            'newDate':''

        };
    },
    setup() {
        
    },
    methods: {
        authorization(){
            const pack = {
                email: this.email,
                password: this.password,
                token: null,
                expires_in: null
            }
            //console.log('pack:', pack)
            http.post("/login/entering", pack)
            .then(response => {
               // console.log('Pierwsze wywołanie: ',  this.$store.getters.logInState)
                this.email = "garski@wp.pl"
                this.password = ""
                this.token = response.data.token
                //this.expires_in = response.data.expires_in * 1000
                //const now = new Date()
                //const expireDate = new Date(now.getTime() + this.expires_in)
                localStorage.setItem('token', this.token)
                this.$store.dispatch('setUserId', response.data.userId);
                this.$store.dispatch('login');
                //console.log('drugie wywołanie: ', this.$store.getters.logInState)
                //console.log('userId: ', this.$store.getters.getUserId)
                this.$store.dispatch('setTodayDate');
                
            })
            .then(()=>{
                this.getNumOfRepeatCards()
            })
            .then(()=>{
                this.$router.push('/porch')
            })
            .catch(error => {
                this.errorMessage = error.message;
                console.error("coś poszło nie tak w authorization...", error);
            });
        },
        getNumOfRepeatCards(){
            let userId = this.$store.getters.getUserId
            const url = "/repeatQueries/getRepeatsNumsForCourses/" + userId;
            //console.log('url z pytania', url)
            http.get(url)
            .then((response) => {
                //console.log('dane z requesta pobrania powtórek dla kursu:', response.data)

                this.$store.dispatch('repeat/setRepeatsForCourses', response.data);

                console.log('ze stora po pytaniu o liczbe powtórek: ', this.$store.getters['repeat/getRepeatsForCourses'])
            })
            .then(()=>{
                //this.getCoursesFullInfo();
            })
            .catch((error) => {
                this.errorMessage = error.message;
                    console.error("coś poszło nie tak w getNumOfRepeatCards...", error);
            });
        }
    }
}
</script>
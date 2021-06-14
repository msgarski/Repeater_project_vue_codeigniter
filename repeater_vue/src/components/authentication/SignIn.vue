<template>
    <h1 id="title">Logowanie</h1>
    <div class="nix">
        <form @submit.prevent="authorization" class="form">
            <div>
                <label for="email" >E-mail</label>
                <input type="email" name="email" id="email" v-model.trim="email">
            </div>

            <div>
                <label for="password">Hasło</label>
                <input type="password" name="password" v-model.trim="password">
            </div>

                    <button class="button">Zatwierdź</button>
        </form>
    </div>
    <div class="buttons">
        <div class="btn" id="btn-1">
            <button class="button-1"><router-link to="/">Cofnij</router-link></button>   
        </div>
        
        <div class="btn" id="btn-2">
            <button class="button-1"><router-link to="/forgot">Zapomniane hasło...</router-link></button>
        </div> 
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

<style scoped>
#title {
    margin-top: 70px;
    text-align: center;
    color: gray;
    }
.form {
    margin-top: 100px;
    padding-left: 40%;
    }
label {
    display: block;
    font-size: 16px;
    font-style: italic;
    }
input {
    width: 40%;
    padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border-radius: 5px;
}

.button {
background-color: #ffae00; /* Green */
border: none;
color: white;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 14px;
width: 100px;
height: 40px;
    border-radius: 20px;
}
.buttons {
    width: 100%;
    padding-left: 25%;
    padding-top: 5%;
}
.button-1 {
background-color: #718bff; /* Green */
border: none;
color: white;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 14px;
height: 40px;
    border-radius: 20px;
}
.btn {
    width: 20%;
    text-align: center;
    float: left;
    padding: 20px;
    
}

a {
    color: white;
}



</style>
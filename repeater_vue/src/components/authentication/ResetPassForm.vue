<template>
    <div v-if="formSent">
        <p>Dziękujemy za przesłanie formularza</p><br>
            <p>Twoje hasło zostało zmienione</p>
            <div>
                <router-link to="/signin"><buton>Zaloguj się nowymi danym</buton></router-link>
            </div>

    </div>
    <div v-else>
        <div>formularz resetowania hasła</div>

        <p>Wprowadź nowe hasło:</p>
        <form @submit.prevent="resetPassword">
            <div>
                <label for="password">Podaj hasło</label>
                <input type="password" name="password" v-model.trim="password">
            </div>

            <div>
                <label for="password_confirmation">Powtórz hasło</label>
                <input type="password" name="password_confirmation" v-model.trim="password_confirmation">
            </div>
            <button>Wyślij</button>
        </form>
    </div>
        
</template>

<script>
import http from '../../plugins/axios.js'

export default {
    name: 'ResetPassForm',
    data(){
        return{
            token: this.$route.params.token,
            password: '',
            password_confirmation: '',
            formSent: false,
            passChanged: false
        };
    },
    setup() {
        
    },
    created(){
        console.log(this.$route.params.token)
        alert(this.$route.params.token)
    
    },
    methods:{
        resetPassword(){
            const pack = {
                password: this.password,
                password_confirmation: this.password_confirmation
            }
            let url = "/password/newpassword/" + this.token;
            console.log('pack:', url)

            http.post("/password/newpassword/" + this.token, pack)
            .then(response => {
                console.log(response)
                // todo potwierdzić userowi dopiero po odebraniu, że hasło jest zmienione
                //this.$router.push('/signin')
                this.formSent;
            })
                .catch(error => {
                    this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
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
height: 25px;
border-radius: 12px;
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
height: 25px;
border-radius: 12px;
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
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
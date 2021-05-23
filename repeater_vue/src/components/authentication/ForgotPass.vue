<template>
<div v-if="emailSent">
    <p>email z linkiem do zresetowania Twojego hasła, został wysłany na adres podany przy rejestracji</p>
</div>
<div v-else-if="userNotFound">
    <p>Użytkownik o podanym adresie email, nie jest zarejestrowany...</p>
</div>
<div v-else>
    <form @submit.prevent="passRemind">
        <h1>Przypomnienie hasła</h1>
            <div>
                <label for="email">Adres email</label>
                <input type="text" name="email" v-model.trim="email" id="email">
            </div>

            <button>Wyślij</button>
        </form>
</div>
    

    <div>
        <router-link to="/">Wyjście</router-link>
    </div>
</template>

<script>
//import forgottenPass from '../functions/requests/forgottenPass.js'
import http from '../../plugins/axios.js'

export default {
    data(){
        return{
            email: '',
            emailSent: false,
            userNotFound: false
        };
    },
    setup() {
        
    },
    methods: {
        passRemind(){
            const pack = {
                email: this.email
            }
            console.log('pack:', pack)
            http.post("/password/checking", pack)
            .then(response => {
                if(response.status === 200)
                {
                    console.log('wyslanie udane: ', response)
                    this.emailSent = true;
                }
                //this.$router.push('/signin')
            })
                .catch(error => {
                    this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
                    this.userNotFound = true;
                });
        },
    },
    created(){
        console.log('ścieżka w funkcji created: ', this.$route)
        //alert(this.$route.params.resetToken)
    
    }
}
</script>

<style scoped>

</style>
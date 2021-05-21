<template>
    <div>formularz resetowania hasła</div>

    <p>Wprowadź nowe hasło:</p>
<form @submit.prevent="resetPassword">
<div>
    <label for="password">Podaj hasło</label>
    <input type="password" name="password" v-model="password">
</div>

<div>
    <label for="password_confirmation">Powtórz hasło</label>
    <input type="password" name="password_confirmation" v-model="password_confirmation">
</div>

<button>Wyślij</button>

</form>
</template>

<script>
import http from '../../plugins/axios.js'

export default {
    name: 'ResetPassForm',
    data(){
        return{
            token: this.$route.params.token,
            password: '',
            password_confirmation: ''
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
                //this.$router.push('/signin')
            })
                .catch(error => {
                    this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
                });
        }
    }
}
</script>
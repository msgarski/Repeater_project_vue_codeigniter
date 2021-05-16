<template>
    <h1>Rejestracja</h1>

<form @submit.prevent="register">
<div>
    <label for="name">Imię</label>
    <input type="text" name="name" id="name" v-model.trim="name">
</div>

<div>
    <label for="email">Adres e-mail</label>
    <input type="email" name="email" id="email" v-model="email">
</div>

<div>
    <label for="password">Hasło</label>
    <input type="password" name="password" id="password" v-model.trim="password">
</div>

<div>
    <label for="password_confirmation">potwierdź hasło</label>
    <input type="password" name="password_confirmation" id="password_confirmation" v-model.trim="passwordConfirmation">
</div>

<button>Stwórz konto</button>


</form>

<div>
        <router-link to="/">Wyjście</router-link>
    
</div>
</template>



<script>

//import axios from "axios"
import { http } from '../../plugins/axios.js'

export default {
    name: 'SignUp',
    data(){
        return {
            name: '',
            email: '',
            password: '',
            passwordConfirmation: '',
            formIsValid: true,
            message: null,
            classAlert: null,
            errors: []
        };
        
    },
    setup() {
        
    },
    created(){
    
    },
    methods:{
        register(){
            const pack = {
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.passwordConfirmation
            }

            http.post("/signup/create", pack)
            //.then(transformResponse: (r) => r)
            .then(response => { console.log(response.data )})
            .catch(error => {
                this.errorMessage = error.message;
                console.error("coś poszło nie tak...", error);
            });
           // console.log(r)
        }

        
    }
};
</script>

<style scoped>

</style>
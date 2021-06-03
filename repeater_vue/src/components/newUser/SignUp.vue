<template>
    <h1>Rejestracja</h1>

<form @submit.prevent="register">
<div>
    <label for="name">Imię</label>
    <input type="text" name="name" id="name" v-model.trim="name">
</div>

<div>
    <label for="email">Adres e-mail</label>
    <input type="email" name="email" id="email" v-model.trim="email">
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

import http from '../../plugins/axios.js'

export default {
    name: 'SignUp',
    data(){
        return {
            userId: '',
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
    watch: {
        userId(){
                    this.fillOptionsTable();
        }
    },
    created(){
    
    },
    methods:{
        register(){
            const pack = {
                name                    : this.name,
                email                   : this.email,
                password                : this.password,
                password_confirmation   : this.passwordConfirmation
            }
            // First Request - signup new user:
            
            http.post("/signup/create", pack)
                .then(response => { console.log(response.data );
                    this.userId = response.data;
                    console.log('nowy user ma id: ', this.userId);
                    console.log('cała odpowiedź ', response.data)
                    })
                .catch(error => {
                    this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
                });   
        },
        fillOptionsTable(){
            /*
            *   Method for filling table of user main options
            *   with default data
            */
            // Object with data for filling options table in db:
            const pack2 = {
                learningBatch   :   this.$store.getters['option/getLearningBatchLimit'],
                learningLim     :   this.$store.getters['option/getLearningDayLimit'],
                repeatLim       :   this.$store.getters['option/getRepeatDayLimit'],
                overlearn       :   this.$store.getters['option/getOverlearning'],
                userId          :   this.userId
            };

            // Http request to options table in db:
            http.post('/options/insertOptions', pack2)
                .then(response=>{
                    console.log('odpowiedź serwera na żądanie nr 2: ', response);
                })
                .catch(error => {
                    this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
                }); 
        }
    }
};
</script>

<style scoped>

</style>
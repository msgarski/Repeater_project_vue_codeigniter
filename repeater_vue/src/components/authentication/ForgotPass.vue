<template>
    <form @submit.prevent="passRemind">
    <h1>Przypomnienie hasła</h1>
        <div>
            <label for="email">Adres email</label>
            <input type="text" name="email" v-model="email" id="email">
        </div>

        <button>Wyślij</button>
    </form>

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
                console.log(response)
                //this.$router.push('/signin')
            })
                .catch(error => {
                    this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
                });
        },
    },
    created(){
        console.log(this.$route)
        //alert(this.$route.params.resetToken)
    
    }
}
</script>

<style scoped>

</style>
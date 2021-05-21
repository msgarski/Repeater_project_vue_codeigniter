<template>
    <form @submit.prevent="wyslij">

<p>Wprowadź nowe hasło:</p>

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
export default {
    data(){
        return{
            password: '',
            password_confirmation: ''

        };
    },
    setup() {
        
    },
    methods:{
        wyslij(){
            const pack = {
                password: this.password,
                password_confirmation: this.password_confirmation
            }
            console.log('pack:', pack)
            http.post("/password/newPassword", pack)
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

<style scoped>

</style>
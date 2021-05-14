<template>
    <form @click.prevent="dalej">
    <h1>Przypomnienie hasła</h1>
        <div>
            <label for="email">Adres email</label>
            <input type="text" name="email" id="email">
        </div>

        <button>Wyślij</button>
    </form>

    <div>
        <router-link to="/">Wyjście</router-link>
    </div>
</template>

<script>
export default {
    setup() {
        
    },
    methods: {
        dalej(){

        },
    },
    created(){
        console.log(this.$route)

    }
}
</script>

<style scoped>

</style>
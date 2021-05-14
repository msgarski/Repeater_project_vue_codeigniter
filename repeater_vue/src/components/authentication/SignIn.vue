<template>
    <h1>Logowanie</h1>

    <form @click.prevent="go">
        <div>
            <label for="email">email</label>
            <input type="text" name="email" id="email">
            </div>

            <div>
            <label for="password">Password</label>
            <input type="password" name="password">
        </div>

                <button>Zatwierdź</button>

    </form>
    <div>
        
    </div>
    <div>
        <router-link to="/">Wyjście</router-link>
    
        <router-link to="/forgot">Zapomniane hasło...</router-link>
    </div>
    

</template>

<script>
export default {
    name: 'SignIn',
    data(){
        return {

        };
    },
    setup() {
        
    },
    methods: {
        go(){

        },
    }
}
</script>
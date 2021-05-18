<template>
    <h1>Logowanie</h1>

    <form @click.prevent="authorization">
        <div>
            <label for="email" >email</label>
            <input type="email" name="email" id="email" v-model="email">
            </div>

            <div>
            <label for="password">Password</label>
            <input type="password" name="password" v-model="password">
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
import http from '../../plugins/axios.js'

export default {
    name: 'SignIn',
    data(){
        return {
            'email': '',
            'password': '',
            'expires_in': '',
            'token': '',
            'newDate':''

        };
    },
    setup() {
        
    },
    methods: {
        authorization(){
            const pack = {
                email: this.email,
                password: this.password,
                token: null,
                expires_in: null
            }
            console.log('pack:', pack)
            http.post("/login/entering", pack)
            .then(response => {
                this.email = ""
                this.password = ""
                this.token = response.data.access_taken
                this.expires_in = response.data.expires_token * 1000
                const now = new Date()
                const expireDate = new Date(now.getTime() + this.expires_in)
                localStorage.setItem('token', this.token)
                localStorage.setItem('expires', expireDate)

                //Store dispatch:
                this.$store.dispatch('login', this.expires_in);
            })
                //.then(response => { console.log(response.data )})
                .catch(error => {
                    this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
                });
        },
    }
}
</script>
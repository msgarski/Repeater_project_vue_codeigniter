<template>
<div v-if="isLoggedIn">
    <div>
        <button @click="logout">Wyjście</button>
    </div>
</div>
<div v-else>
    <div>
        <button>
            <router-link to="/signin">Logowanie</router-link>
        </button>
    </div>
    <div>
        <button>
            <router-link to="/signup">Nie mam jeszcze konta</router-link>
        </button>
        
    </div>
</div>
    
</template>



<script>

export default {
    name: 'HelloSite',
    computed:{
        isLoggedIn(){
            return this.$store.getters.logInState;
    }
    },
    methods:{
        logout(){
            this.$store.dispatch('logout');
        }
    }
    
}
</script>

<style scoped>

</style>

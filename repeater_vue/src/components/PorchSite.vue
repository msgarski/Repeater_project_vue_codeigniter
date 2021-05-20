<template>
    <div v-if="isLoggedIn">
        <h1>Strona wejściowa </h1>
        <h3> </h3>
        <div>
            <button>Krótkie powtórki</button>
        </div>
        <div>
            <button>Zadania na dzisiaj</button>
        </div>
        <div>
            <router-link to="/mainscreen"><button>Przejdź do programu</button></router-link>
        </div>
    </div>
    <div v-else>
        <p>No i sie zmyło...</p>
    </div>
    
</template>


<script>
export default {
    name: 'PorchSite',
    data(){
        return{
            isLogged: this.$store.getters.logInState,
            firstname: 'Robert',
            lastname: 'Górski',
            prawda: 'działa'
        };
    },
    computed:{
        isLoggedIn(){
            return this.$store.getters.logInState;
        },
        
    }
    
    
}
</script>

<style scoped>

</style>

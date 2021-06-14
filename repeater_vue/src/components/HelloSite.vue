<template>
<header>
    <div class="nic">
    <div v-if="isLoggedIn">
    <div class="header">
        <div class="btn">
            <button @click="logout" class="button">Wyloguj</button>
        </div>
        
    </div>
    </div>
    <div v-else>
        <router-link to="/"></router-link>
    </div>
</div>
</header>


    
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
    .header {
        background-color: #718bff;
        height: 60px;
        position: fixed;
        width: 100%;
    }
    .button {
background-color: #ffae00; /* Green */
border: none;
color: white;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 14px;
height: 40px;
border-radius: 20px;
width: 80px;
margin-right: 20%;
margin-top: 10px;
}
.btn {
    width: 20%;
    text-align: center;
    float: right;
    padding: 0px;
}

a {
    color: white;
}
</style>

<template>
    <h1>Witaj w programie REPEATER: {{info()}}</h1>
    <div>
        <router-link to="/signin">Logowanie</router-link>
    </div>

    <div>
        <router-link to="/signup">Nie mam jeszcze konta</router-link>
    </div>
            <router-view></router-view>
</template>



<script>

export default {
    name: 'HelloSite',
    setup() {
        
    },
    props: {

    },
    methods: {
        info(){
            //console.log(this.$http)
        }

    }
}
</script>

<style scoped>

</style>

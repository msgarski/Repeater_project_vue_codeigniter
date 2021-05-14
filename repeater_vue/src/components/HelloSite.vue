<template>
    <h1>Witaj w programie REPEATER</h1>
    <!-- <router-view></router-view> -->
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

    }
}
</script>

<style scoped>

</style>

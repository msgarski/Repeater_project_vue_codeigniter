<template>
    <li>
        <router-link :to="'/innerlesson/' + id">
            <div>
                <hr>
                <p>Numer lekcji: {{ id }}</p>
                <p> Kurs {{ name }}</p>
                <p>Opis: {{ description }}</p>
            </div>   
        </router-link>
    </li>
</template>

<script>
export default {
    name: 'course-lesson',
    props: [
        'id',
        'name',
        'description'
    ],
    data(){
        return{

        };
    },
    setup() {
        
    },
    methods:{

    }
}
</script>

<style scoped>

</style>
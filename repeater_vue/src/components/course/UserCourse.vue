<template>
    <li>
        <router-link :to="'/innercourse/' + courseId">
            <div>
                <hr>
                <p>Numer kursu: {{ courseId }}</p>
                <p> Kurs {{ name }}</p>
                <p>Opis: {{ description }}</p>
            </div>   
        </router-link>
    </li>
</template>

<script>
// To pasek kursu w widoku głównym
export default {
    name: 'user-course',
    props:[
        'courseId',
        'name',
        'description'
    ],
    data(){
        return{

        };
    },
    setup() {
        
    },
    methods: {

    }
}
</script>
<template>
    <li>
        <router-link :to="'/innercourse/' + courseId">
            <div>
                <hr>
                <p>Numer kursu: {{ courseId }}</p>
                <p> Kurs {{ name }}</p>
                <p>Opis: {{ description }}</p>
            </div>
            <div>
                <p>Ile słów do nauki w kursie: </p>
                <router-link :to="'/learning/' + courseId"><button>Nauka słów w kursie</button></router-link>
                
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
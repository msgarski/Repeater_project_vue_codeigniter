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
                <!-- <router-link :to="'/learning/' + courseId"><button @click="getBatchLearningOfCourse">Nauka słów w kursie</button></router-link> -->
                <button @click="getBatchLearningOfCourse">Nauka słów w kursie</button>
            </div>   
        </router-link>
    </li>
</template>

<script>
import http from '../../plugins/axios.js';

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
            batchLimit  :   this.$store.getters['option/getLearningBatchLimit'],
            readiness   :   false
        };
    },
    setup() {
        
    },
    methods: {
        getBatchLearningOfCourse(){
            // pobranie potrzebnej ilości słów:
        console.log('Pobieranie nowej partii kart z bazy danych...', this.courseId, this.batchLimit);
        this.$store.dispatch('learning/setIndex', 0);
        console.log('jaki index? ', this.$store)

        http.get('learning/CardsForLearningBatch/' + this.courseId + '/' + this.batchLimit)
            .then((result) => {
                this.$store.dispatch('learning/setBatchForLearning', result.data);
                
                console.log('widok danych z http: ', result.data);
            })
            .then(()=>{
                this.readiness = true;
                this.$store.dispatch('learning/resetLoopNumber');
                this.$router.push('/learning/' + this.courseId)               
            })
            .catch((error) => {
                this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
            });
        }

    }
}
</script>
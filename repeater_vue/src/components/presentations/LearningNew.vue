<template>
    <h1>Nauka nowych słów z kursu: {{courseId}}</h1>
    <h3>Limit dnia: {{dayLimit}}, limit tury: {{batchLimit}}</h3>
    
    
    <div>
        <learn-present></learn-present>
    </div>


    
</template>

<script>
//import http from '../../plugins/axios.js';
import LearnPresent from './LearnPresent';

export default {
    name: 'learning-new',
    components: {
        'learn-present'   :   LearnPresent
    },
    data() {
        return {
            wordId      :   0,
            courseId    :   this.$route.params.courseId,
            dayLimit    :   this.$store.getters['option/getLearningDayLimit'],
            batchLimit  :   this.$store.getters['option/getLearningBatchLimit'],
            listLength  :   null, // todo na nowo obliczyć
            readiness   :   false,
            learningEnd :   false
        };
    },
    setup() {
        
    },
    methods: {
        previous(){
            this.wordId -= 1;
        }
    },
    created(){
        // // pobranie potrzebnej ilości słów:
        // console.log('Pobieranie nowej partii kart z bazy danych...');
        // http.get('learning/CardsForLearningBatch/' + this.courseId + '/' + this.batchLimit)
        //     .then((result) => {
        //         this.$store.dispatch('learning/setBatchForLearning', result.data);
                
        //         //console.log('widok sklepu z http: ', this.$store);
        //     })
        //     .then(()=>{
        //         this.readiness = true;
        //         this.listLength = this.$store.getters['learning/getBatchForLearning'].length;
        //         this.$store.dispatch('learning/resetLoopNumber');
        //     })
        //     .catch((error) => {
        //         this.errorMessage = error.message;
        //             console.error("coś poszło nie tak...", error);
        //     });
    }
}
</script>

<style scoped>

</style>
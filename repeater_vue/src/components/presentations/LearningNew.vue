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
        
    }
}
</script>

<style scoped>

</style>
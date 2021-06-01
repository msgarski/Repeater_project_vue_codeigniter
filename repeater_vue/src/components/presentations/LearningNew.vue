<template>
    <h1>Nauka nowych słów z kursu: {{courseId}}</h1>
    <h3>Limit dnia: {{dayLimit}}, limit tury: {{batchLimit}}</h3>
</template>

<script>
import http from '../../plugins/axios.js'


export default {
    name: 'learning-new',
    data() {
        return {
            courseId    :   this.$route.params.courseId,
            dayLimit    :   this.$store.getters['option/getLearningDayLimit'],
            batchLimit  :   this.$store.getters['option/getLearningBatchLimit']
        };
    },
    setup() {
        
    },
    created(){
        console.log('przed wysłaniem: ', this.batchLimit);
        // pobranie potrzebnej ilości słów:
        http.get('learning/CardsForLearningBatch/' + this.courseId + '/' + this.batchLimit)
            .then((result) => {
                console.log('oto same data json: ', result.data)

                // this.$store.dispatch('option/setLearningBatchLimit', result.data.batch_learning_limit);
                // this.$store.dispatch('option/setLearningDayLimit', result.data.day_learning_limit);
                // this.$store.dispatch('option/setOverlearning', result.data.overlearning);
                // this.$store.dispatch('option/setRepeatDayLimit', result.data.day_repeat_limit);


            }).catch((error) => {
                this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
            });
    }
}
</script>

<style scoped>

</style>
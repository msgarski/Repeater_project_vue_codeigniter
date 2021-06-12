<template>
    <div>
        <h1>Wnętrze lekcji nr: {{ lessonId }}</h1>
    </div>



<button><router-link :to="'/massimport/' + lessonId">Dodaj wiele kart</router-link></button>

<button><router-link :to="'/singleimport/' + lessonId">Dodaj karty pojedynczo</router-link></button>


<div>
    <label for="tryouts">Oczekujące testy:</label>
</div>

<div>
    <label for="repetitions">Powtórki na dziś:</label>
</div>

<p>Twoje karty w tej lekcji:</p>
<lesson-table :lessonId="lessonId"></lesson-table>

<div>
    <!-- <a href="">Powrót do kursu</a> -->
    <button @click="backToPrevious">Powrót do widoku kursu</button>
</div>

</template>

<script>
import http from '../../plugins/axios.js'
import LessonTable from './LessonTable.vue'

export default {
    name: 'inner-lesson',
    components: {
        'lesson-table'  :   LessonTable,
    },
    data(){
        return{
            lessonId: this.$route.params.lessonId,
            cards   :   null,
        };
    },
    created() {
        //his.getCardsForLesson();
    },
    methods: {
        backToPrevious: function(event){
            this.$router.go(-1);
           // alert('nic się nie stało')
        },
        getCardsForLesson(){
            http.get('cards/fillLessonTable/' + this.lessonId)
            .then((result) => {
                this.cards = result.data;

                
                console.log('widok słów do lekcji z http: ', this.cards[0].answer);
            })
            .then(()=>{
                
                this.$store.dispatch('learning/resetLoopNumber');
            })
            .catch((error) => {
                this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
            });
        },
    }
}
</script>

<style scoped>

</style>
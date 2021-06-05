<template>
    <li>
        <router-link :to="'/innercourse/' + courseId">
            <div>
                <hr>
                <p>Numer kursu: {{ courseId }}   </p>
                <div>Liczba kart w kursie: {{ courseInfo.card_amount }}</div>
                <div>Liczba lekcji w kursie: {{ courseInfo.lesson_amount }}</div>
                <div>Do nauki: {{ courseInfo.for_learning }}</div>
                <div>trudne słowa:  {{ courseInfo.awkward_amount }}</div>
                <div>Do powtórek:  {{ courseInfo.for_repeating }} </div>
                <p> Kurs {{ name }}  </p>
                <p>Opis: {{ description }}</p>
            </div>
            <div v-show="courseInfo.card_amount > 4">
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
            readiness   :   false,
            courseInfo  :   this.fillCourseInfo()

        };
    },
    created() {
        //this.courseInfo = this.$store.getters['course/getCourseInfoById'];
        //console.log('info o kursie z gettersa: ', this.courseInfo);
        //this.courseInfo = this.fillCourseInfo();

    },
    methods: {
        fillCourseInfo(){
            let sto = this.$store.getters['course/getCourseInfoById']
            return sto.find(el=>el.course_id == this.courseId)
            
        },
        getBatchLearningOfCourse(){
            // Reseting batch of learning values in store:
        console.log('Pobieranie nowej partii kart z bazy danych...', this.courseId, this.batchLimit);
        this.$store.dispatch('learning/setIndex', 0);
        this.$store.dispatch('learning/resetLoopNumber');
        this.$store.dispatch('learning/setEndLearning', 0);

        console.log('jaki index? ', this.$store)
            // getting needed amount of cards:
        http.get('learning/CardsForLearningBatch/' + this.courseId + '/' + this.batchLimit)
            .then((result) => {
                let dim = result.data.length
                if( dim < 5)
                {
                    alert("znaleźliśmy tylko " + dim + " słów, to za mało")
                }
                else
                {
                    this.$store.dispatch('learning/setBatchForLearning', result.data);
                }
                
                
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
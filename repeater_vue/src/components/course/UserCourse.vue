<template>
    <li>
        <router-link :to="'/innercourse/' + courseId">

            <div>
                <!-- <p>Numer kursu: {{ courseId }}   </p> -->
                <div class="course-info">
                    <p class="name"> {{ name }}  </p>
                    <p class="description">{{ description }}</p>
                </div>

                <div class="course-lessons">
                    <div class="name-col">Lekcji w kursie</div>

                    <div class="number">{{ courseInfo.lesson_amount }}</div>
                </div>

                <div class="course-cards">

                    <div class="name-col">Kart w kursie</div>

                    <div class="number">{{ courseInfo.card_amount }}</div>
                </div>
                
                <div class="learning">
                    <div class="name-col">Do nauki</div>
                    <div class="number">{{ courseInfo.for_learning }}</div>

                    <div v-show="courseInfo.for_learning > 10" id="btn">
                        <!-- <router-link :to="'/learning/' + courseId"><button @click="getBatchLearningOfCourse">Nauka słów w kursie</button></router-link> -->
                        <button @click="getBatchLearningOfCourse" class="button">Ucz się</button>
                    </div>
                </div>
                
                <div class="repeating">
                    <div class="name-col">Do powtórek</div>
                    <div class="number">{{ courseInfo.for_repeating }}</div>

                    <div v-show="courseInfo.for_repeating > 5" id="btn">
                        <!-- <router-link :to="'/learning/' + courseId"><button @click="getBatchLearningOfCourse">Nauka słów w kursie</button></router-link> -->
                        <button @click="getBatchLearningOfCourse" class="button">Powtarzaj</button>
                    </div>
                </div>
                
                <div class="diff-cards">
                    <div class="name-col">Trudne słowa</div>

                    <div class="number">{{ courseInfo.awkward_amount }}</div>
                </div>
                
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

<style scoped>
li {
    margin: 1rem 0;
    border: 1px solid #424242;
    box-shadow: 3px 3px 3px 3px grey;
    border-radius: 12px;
    padding: 1rem;
    height: 60px;
}
.course-info {
    display: inline-block;
    text-align: left;
    float: left;
    width: 30%;
    }
.name {
    font-style: inherit;
    color: #3a0061;
    font-weight: bold;
    font-size: 22px;
    padding: 5px;
}
.name-col {
    font-style: inherit;
    color: #3a0061;
    font-weight: bold;
    font-size: 14px;
    padding: 5px;
}
.number {
    font-weight: bold;
    font-size: 20px;
    color: #718bff;
}
.course-lessons {
    text-align: center;
    float: left;
    width: 10%;
}
.course-cards {
    text-align: center;
    float: left;
    width: 10%;
}
.learning {
    text-align: center;
    float: left;
    width: 10%;
}
.repeating {
    text-align: center;
    float: left;
    width: 10%;
}
.diff-cards {
    text-align: center;
    float: left;
    width: 10%;
}
a {
    color: grey;
}
.button {
background-color: #ffae00; /* Green */
border: none;
color: white;
text-align: center;
text-decoration: none;
font-size: 14px;
height: 20px;
border-radius: 10px;
}
#btn {
    width: 100%;
    padding-top: 5px;
}
.actions {
  display: flex;
  justify-content: flex-end;
}

</style>
<template>
    <li>
        <router-link :to="'/innerlesson/' + lessonId">
            <div>
                <div class="lesson-info">
                    <p class="name"> Temat: {{ name }}</p>
                    <p class="description">{{ description }}</p>
                </div>
                <!-- <p>Numer lekcji: {{ lessonId }}</p> -->
                <div v-if="lessonInfo">
                    <div class="lesson-cards">
                        <div class="name-col">Kart w lekcji</div>

                        <div class="number">{{ lessonInfo.card_amount }}</div>
                    </div>
                    
                    <div class="learning">
                        <div class="name-col">Do nauki</div>

                        <div class="number">{{ lessonInfo.for_learning }}</div>

                        <div v-show="lessonInfo.for_learning >= 10" id="btn">
                            <!-- <router-link :to="'/learning/' + courseId"><button @click="getBatchLearningOfCourse">Nauka słów w kursie</button></router-link> -->
                            <button @click="getBatchLearningOfCourse" class="button">Ucz się</button>
                        </div>
                    </div>
                    
                    <div class="repeating">
                        <div class="name-col">Do powtórek</div>

                        <div class="number">{{ lessonInfo.for_repeating }} </div>

                        <div v-show="lessonInfo.for_repeating > 5" id="btn">
                            <!-- <router-link :to="'/learning/' + courseId"><button @click="getBatchLearningOfCourse">Nauka słów w kursie</button></router-link> -->
                            <button @click="getBatchLearningOfCourse" class="button">Powtarzaj</button>
                        </div>
                    </div>
                </div>
                
                <div class="btn-edit">
                    <router-link :to="'/editlesson/' + lessonId"><button class="button">Edytuj</button></router-link>
                </div>

                <div class="button-tab">
                    <div class="btn">
                        <router-link :to="'/massimport/' + lessonId"><button class="button-2">Dodaj wiele kart</button></router-link>
                    </div>
                    <div class="btn">
                        <router-link :to="'/singleimport/' + lessonId"><button class="button-2">Dodaj karty pojedynczo</button></router-link>
                    </div>
                </div>

            </div>   
        </router-link>
    </li>
</template>

<script>
//import http from '../../plugins/axios.js';

export default {
    name: 'course-lesson',
    props: [
        'lessonId',
        'name',
        'description'
    ],
    data(){
        return{
            lessonInfo  : null,
            //userId      :   this.$store.getters.getUserId

        };
    },
    created() {
        this.fillLessonInfo();
        
    },
    methods:{
        fillLessonInfo(){
            let sto = this.$store.getters['lesson/getLessonInfoById']
            this.lessonInfo = sto.find(el=>el.lesson_id == this.lessonId)
        },
        
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
.btn-edit {
    float: right;
    margin-right: 5%;
}
.btn {
    padding: 7px;
    margin-left: 65%;
}
.lesson-info {
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
.lesson-cards {
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
.button-2 {
background-color: #718bff; /* Green */
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
    padding: 5px;
}
.actions {
  display: flex;
  justify-content: flex-end;
}
</style>
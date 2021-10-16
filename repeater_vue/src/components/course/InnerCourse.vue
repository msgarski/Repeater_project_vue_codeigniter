<template>
    <!-- <div>Powtórki na dziś</div> -->
    <div class="container">
        <div>
            <!-- <h1>Wnętrze kursu nr: {{ courseId }}</h1> -->
            <!-- <h1>Nazwa kursu: angielski</h1> -->
        </div>
        <div>
            <div class="title">
                <p>Twoje lekcje w kursie:</p>
            </div>
            <div class="button-tab">
                <div class="btn">
                    <router-link :to="'/newlesson/' + courseId" >
                        <button class="button-1">Dodaj nową lekcję</button>
                    </router-link>
                </div>
                <div class="btn">
                    <router-link to="/settings"><button class="button">Opcje kursu</button></router-link>
                </div>
            </div>
        </div>
    </div>


    <div class="list-container" v-if="lessons">
        <ul v-if="(lessons.length != 0) && lessonsInfoIsLoaded">
            <course-lesson
                v-for="lesson in lessons" 
                    :key="lesson.lesson_id"
                    :lessonId="lesson.lesson_id"
                    :name="lesson.name" 
                    :description="lesson.description">
            </course-lesson>
        </ul>
        <div v-else-if="!lessonsInfoIsLoaded"><h1>Loading ...</h1></div>
        <div v-if="lessons.length == 0">
            <h2 class="title">Nie stworzyłeś jeszcze lekcji do tego kursu...</h2>
                <router-link :to="'/newlesson/' + courseId" >
                    <button class="button">Dodaj lekcję</button>
                </router-link>
        </div>
        <div class="btn-1">
        <!-- <a href="">Powrót do kursu</a> -->
        <button @click="backToPrevious" class="button">Powrót do widoku głównego</button>
    </div>
    </div>
    <div v-else><h1>Loading ...</h1></div>


</template>

<script>
import CourseLesson from '../lesson/CourseLesson.vue'
import http from '../../plugins/axios.js'

export default {
    name: 'inner-course',
    components: {
        'course-lesson': CourseLesson
    },
    data(){
        return{
            courseId: this.$route.params.courseId,
            lessons: null,
            lessonsInfoIsLoaded   :   false,
            userId      :   this.$store.getters.getUserId

        };
    },
    provide() {
        return {courseId: this.courseId}
    },
    mounted(){
        this.getLessonsFullInfo();
        this.insideCourse();
    },
    setup() {
        
    },
    methods:{
        backToPrevious: function(event){
            this.$router.go(-1);
           // alert('nic się nie stało')
        },
        getLessonsFullInfo(){
            let userId = this.$store.getters.getUserId;
            const url = "/courseQueries/getFullInfoOfUserLessons/" + userId;

            http.get(url)
            .then(response => {
                this.$store.dispatch('lesson/setAllLessons', response.data);

                console.log('dane z requesta lessonInfo:', response.data)
                //let sto = this.$store.getters['lesson/getLessonInfoById']
                //console.log('ze sklepu na koniec szukania lekcji:', sto.find(el=>el.lesson_id == 2))
            })
            .then(()=>{
                //this.fillLessonInfo();
                this.lessonsInfoIsLoaded = true;
            })
            .catch(error => {
                this.errorMessage = error.message;
                console.error("coś poszło nie tak...", error);
            });
        },
        insideCourse(){
            const url = "/course/getInsideCourse/" + this.courseId;
            console.log('pack:', url)

            http.get(url)
            .then(response => {
                console.log('dane z requesta o getInsideCourse ', response.data)
                this.lessons = response.data
            })
            .then(()=>{
                this.getLessonsFullInfo();
            })
            .catch(error => {
                this.errorMessage = error.message;
                console.error("coś poszło nie tak...", error);
            });
        }

    }
}
</script>

<style scoped>
    .container {
    position: absolute;
    width: 80%;
    height: 60px;
    border: 1px solid grey(39, 39, 39);
    border-radius: 12px;
    box-shadow: 2px 2px 2px 2px grey;
    margin-top: 80px;
    margin-left: 10%;
    margin-right: auto;
    padding-bottom: 5px;
    padding-top: auto;
}
.list-container {
    position: absolute;
    width: 80%;
    border-radius: 12px;
    margin-top: 160px;
    margin-left: 10%;
    margin-right: 100px;
}
.title {
    margin-top: 0px;
    position: relative;
    color: gray;
    font-weight: bold;
    font-size: 25px;
    margin-left: 10px;
    float: left;
    margin-top: 20px;
    }
.button-tab {
    display: flex;
    justify-content:space-between;
    padding-right: 7%;
    padding-left: 10%;
}
.form {
    padding-top: 40px;
    padding-bottom: 40px;
    padding-left: 40%;
    }
.button {
background-color: #ffae00; /* Green */
font-weight: bold;
position: relative;
border: none;
color: white;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 14px;
height: 40px;
border-radius: 20px;
margin-top: 12px;
}
.button-1 {
background-color: #718bff; /* Green */
font-weight: bold;
position: relative;
border: none;
color: white;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 14px;
height: 40px;
border-radius: 20px;
width: 200px;
margin-top: 12px;
}
#btn {
    width: 100%;
    padding: 10px;
}
ul {
  list-style: none;
  margin: 0;
  padding: 0;
}
a {
    color: white;
}
</style>
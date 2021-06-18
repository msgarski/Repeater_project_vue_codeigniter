<template>
    <!-- <div>Powtórki na dziś</div> -->
    <div class="container">
        <div>
            <!-- <h1>Wnętrze kursu nr: {{ courseId }}</h1> -->
            <!-- <h1>Nazwa kursu: angielski</h1> -->
        </div>
        <div v-if="!lessons||lessons.length == 0">
            <p>Nie stworzyłeś jeszcze lekcji... na razie do nowego kursu...
                <router-link :to="'/newlesson/' + courseId" >
                    Dodaj jakąś lekcję
                </router-link></p>
        </div>
        <div v-else>
            <div class="title">
                <p>Twoje lekcje w kursie: hiszpański</p>
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
    <div class="list-container">
            <ul>
                <course-lesson
                    v-for="lesson in lessons" 
                        :key="lesson.lesson_id"
                        :lessonId="lesson.lesson_id"
                        :name="lesson.name" 
                        :description="lesson.description">
                </course-lesson>
            </ul>
        </div>
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
            userId      :   this.$store.getters.getUserId

        };
    },
    provide() {
        return {courseId: this.courseId}
    },
    created(){
        this.insideCourse();
        this.getLessonsFullInfo();
    },
    setup() {
        
    },
    methods:{
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
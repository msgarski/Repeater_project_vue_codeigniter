<template>
    <div>Powtórki na dziś</div>
    <div>
        <h1>Wnętrze kursu nr: {{ courseId }}</h1>
    </div>

    <div>
        <p>Twoje lekcje:</p>
    </div>
    <div v-if="!lessons||lessons.length == 0">
        <p>Nie stworzyłeś jeszcze lekcji... na razie do nowego kursu...
            <router-link :to="'/newlesson/' + courseId" >
                Dodaj jakąś lekcję
            </router-link></p>
    </div>
    <div v-else>
        <div>
            <router-link :to="'/newlesson/' + courseId" >
                <button>Dodaj nową lekcję</button>
            </router-link>
        </div>
        <ul>
            <course-lesson
                v-for="lesson in lessons" 
                    :key="lesson.lesson_id"
                    :lessonId="lesson.lesson_id"
                    :name="lesson.name" 
                    :description="lesson.description">
            </course-lesson>
            <hr>
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
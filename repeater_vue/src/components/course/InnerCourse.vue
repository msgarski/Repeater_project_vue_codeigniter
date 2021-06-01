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
        <ul>
            <course-lesson
                v-for="lesson in lessons" 
                    :key="lesson.id"
                    :id="lesson.id"
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
            lessons: null
        };
    },
    provide() {
        return {courseId: this.courseId}
    },
    created(){
        const url = "/course/getInsideCourse/" + this.courseId;
        console.log('pack:', url)

        http.get(url)
        .then(response => {
            console.log(response.data)
            this.lessons = response.data
        })
            .catch(error => {
                this.errorMessage = error.message;
                console.error("coś poszło nie tak...", error);
            });
    },
    setup() {
        
    },
    methods:{
        

    }
}
</script>
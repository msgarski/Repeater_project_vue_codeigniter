<template>
    
    <div>
        <router-link to="/newcourse"><button>Dodaj kurs</button></router-link>
        <router-link to="/settings"><button>Opcje główne</button></router-link>
    </div>
    <div>Ekran główny</div>

    <div>Oczekujące testy</div>

    <div>Powtórki na dziś</div>

    <div>
        <p>Twoje kursy:</p>
    </div>
    <div v-if="!courses">
        <p>Nie stworzyłeś jeszcze żadnego kursu...<router-link to="/newcourse">Dodaj jakiś kurs</router-link></p>
    </div>
    <div v-else>
        
        <ul>
            <user-course 
                v-for="course in courses" 
                    :key="course.course_id"
                    :courseId="course.course_id"
                    :name="course.name" 
                    :description="course.description">
            </user-course>
            <hr>
        </ul>
    </div>


</template>

<script>
import UserCourse from './course/UserCourse.vue'
import http from '../plugins/axios.js'

export default {
    name: 'MainScreen',
    components: {
        'user-course': UserCourse
    },
    data(){
        return{
            courses     : null,
            coursesInfo : null,
            userId      : this.$store.getters.getUserId,
            toCourse    : null
        };
    },
    created(){
        
        const url = "/course/getallcoursesforuser/" + this.userId;

        http.get(url)
        .then(response => {
            this.courses = response.data
            console.log('dane po odebraniu w mainscreenie: ', response.data)
        })
        .then(()=>{

        })
        .catch(error => {
            this.errorMessage = error.message;
            console.error("coś poszło nie tak...", error);
        });
        
    },
    methods: {
        
    }
}
</script>

<style scoped>

</style>

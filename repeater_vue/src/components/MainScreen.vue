<template>
    <div class="container">
        <div class="title">
            <p>Twoje kursy:</p>
        </div>
        <div class="btn">
            <router-link to="/newcourse"><button class="button-1">Dodaj kurs</button></router-link>
        </div>
        <div class="btn">
            <router-link to="/settings"><button class="button">Opcje główne</button></router-link>
        </div>
    </div>
    <div>
        <div>Ekran główny</div>

        <div>Oczekujące testy</div>

        <div>Powtórki na dziś</div>
    </div>
    
    <div class="list-container">
            <div v-if="coursesAreLoaded"> 
                <ul v-if="coursesInfoAreLoaded">
                    <user-course 
                        v-for="course in courses" 
                            :key="course.course_id"
                            :courseId="course.course_id"
                            :name="course.name" 
                            :description="course.description">
                    </user-course>
                </ul>
                <div v-else-if="!coursesInfoAreLoaded"><h1>Loading ...</h1></div>
                <div v-else-if="courses.length == 0">Nie masz żadnych kursów, <router-link to="/newcourse">Dodaj jakiś kurs</router-link></div>
            </div>
            <div v-else-if="!coursesAreLoaded">
                    <h1>Loading...</h1>
            </div>
            <div class="btn-1">
        <!-- <a href="">Powrót do kursu</a> -->
        <button @click="backToPrevious" class="button">Powrót</button>
    </div>
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
            toCourse    : null,
            coursesAreLoaded    :   false,
            coursesInfoAreLoaded    :   false
        };
    },
    created(){
        this.getCoursesFullInfo();
    },
    mounted(){
        
        const url = "/course/getallcoursesforuser/" + this.userId;

        http.get(url)
        .then(response => {
            this.courses = response.data
            console.log('dane po odebraniu w mainscreenie: ', response.data)
        })
        .then(()=>{
            this.coursesAreLoaded = true;

        })
        .catch(error => {
            this.errorMessage = error.message;
            console.error("coś poszło nie tak...", error);
        });
        
    },
    methods: {
        backToPrevious: function(event){
            this.$router.push('/porch');
           // alert('nic się nie stało')
        },
        getCoursesFullInfo(){
            const url = "/courseQueries/getFullInfoOfUserCourses/" + this.userId;

            http.get(url)
            .then(response => {
                this.$store.dispatch('course/setAllCourses', response.data);
                console.log('dane z requesta:', response.data)
                let sto = this.$store.getters['course/getCourseInfoById']

                console.log('ze stora na koniec wypeniania pasków kursów:', sto.find(el=>el.course_id == 1))

            })
            .then(()=>{
                //this.getLessonsFullInfo();
                this.coursesInfoAreLoaded = true;
            })
            .catch(error => {
                this.errorMessage = error.message;
                console.error("coś poszło nie tak...", error);
            });
        },
        
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
    margin-top: 110px;
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
float: left;
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
width: 100px;
margin-left: 30%;
margin-right: 30%;
margin-top: 12px;
float: left;
}
#btn {
    width: 100%;
    float: left;
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

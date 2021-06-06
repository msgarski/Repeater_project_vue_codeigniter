<template>
    <div v-if="isLoggedIn">
        <h1>Strona wejściowa </h1>
        <h3> </h3>
        <div v-if="isRepeating">
            <router-link :to="'/repeating/' + courseId">
                <button @click="getBatchForRepeat">Krótkie powtórki</button>
            </router-link>
            <div>
                <fast-repeating
                    v-for="course in repeatsForCourses"
                        :key="course.course_id"
                        :courseId="course.course_id"
                        :name="course.name"
                        :repAmount="course.repeats">
                </fast-repeating>
            </div>
            <div >

            </div>
        </div>

        <div>
            <div>
                <button>Zadania na dzisiaj</button>
            </div>
            <div>
                <router-link to="/mainscreen"><button>Przejdź do programu</button></router-link>
            </div>
        </div>
        
    </div>
    <div v-else>
        <p>No i sie zmyło...</p>
    </div>
    
</template>


<script>
import http from '../plugins/axios.js'
import FastRepeating from './presentations/FastRepeating.vue'

export default {
    name: 'PorchSite',
    components: {
        'fast-repeating': FastRepeating
    },
    data(){
        return{
            isLogged: this.$store.getters.logInState,
            userId  :   this.$store.getters.getUserId,
            courseId:  1, //! todo zastąpić to wyborem kursu
            firstname: 'Robert',
            lastname: 'Górski',
            isRepeating :   false,
            repeatsForCourses   :   null,
            prawda: 'działa'
        };
    },
    computed:{
        repeating(){
            return this.$store.getters['repeat/getRepeatsForCourses'];
                        
        },
        isLoggedIn(){
            return this.$store.getters.logInState;
        },
        
    },
    watch: {
        repeating(newRepeating, oldRepeating){
            console.log('We have fruits now, yay!', newRepeating )
            this.repeatsForCourses = newRepeating;
            this.isRepeating = true;
        }

    },
    created(){
        this.setLimitsToStore();
        //this.setIsRepeating();
    },
    methods: {
        setLimitsToStore(){
            //console.log('tylko userId: ', this.userId)
            http.get('options/getOptionsForUser/' + this.userId)
                .then((result) => {
                    if(result.data.batch_learning_limit){this.$store.dispatch('option/setLearningBatchLimit', result.data.batch_learning_limit);}
                    if(result.data.day_learning_limit){this.$store.dispatch('option/setLearningDayLimit', result.data.day_learning_limit);}
                    if(result.data.overlearning){this.$store.dispatch('option/setOverlearning', result.data.overlearning);}
                    if(result.data.day_repeat_limit){this.$store.dispatch('option/setRepeatDayLimit', result.data.day_repeat_limit);}
                    console.log('oto same data : ', this.$store.getters['option/getLearningDayLimit']);

                })
                .then(()=>{
                    this.getCoursesFullInfo();
                })
                .catch((error) => {
                    this.errorMessage = error.message;
                        console.error("coś poszło nie tak...", error);
                });
        },
       getCoursesFullInfo(){
            const url = "/courseQueries/getFullInfoOfUserCourses/" + this.userId;

            http.get(url)
            .then(response => {
                this.$store.dispatch('course/setAllCourses', response.data);
                console.log('dane z requesta:', response.data)
                let sto = this.$store.getters['course/getCourseInfoById']

                console.log('ze sklepu na koniec:', sto.find(el=>el.course_id == 1))
            })
            .then(()=>{
                //this.getLessonsFullInfo();
            })
            .catch(error => {
                this.errorMessage = error.message;
                console.error("coś poszło nie tak...", error);
            });
        },
        getBatchForRepeat(){
            let limit = this.$store.getters['repeat/getRepeatingBatchLimit'];
            console.log('limit powtórek ze stora : ', limit)
            const url = "/repeatQueries/getRepeatBatchForCourse/" + this.courseId + "/" + limit;

            http.get(url)
            .then(response => {
                this.$store.dispatch('repeat/setBatchForRepeating', response.data);
                console.log('dane z requesta pobrania powtórek dla kursu:', response.data)

                // let sto = this.$store.getters['course/getCourseInfoById']
                // console.log('ze sklepu na koniec:', sto.find(el=>el.course_id == 1))
            })
            .then(()=>{
                //this.getLessonsFullInfo();
            })
            .catch(error => {
                this.errorMessage = error.message;
                console.error("coś poszło nie tak...", error);
            });
        },
        setIsRepeating(){
            this.repeatsForCourses = this.$store.getters['repeat/getRepeatsForCourses'];
                        console.log('uruchomienie setIsRepeating')

            if(this.repeatsForCourses)
            {
                this.isRepeating = true;
            }
        }
        
        
    }
    
    
}
</script>

<style scoped>

</style>

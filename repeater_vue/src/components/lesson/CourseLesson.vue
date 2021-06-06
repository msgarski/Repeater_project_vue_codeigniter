<template>
    <li>
        <router-link :to="'/innerlesson/' + lessonId">
            <div>
                <hr>
                <p>Numer lekcji: {{ lessonId }}</p>
                <div v-if="lessonInfo">
                    <div>Liczba kart w lekcji: {{ lessonInfo.card_amount }}</div>
                    <div>Do nauki: {{ lessonInfo.for_learning }}</div>
                    <div>Do powtórek:  {{ lessonInfo.for_repeating }} </div>
                </div>
                
                <p> Temat lekcji: {{ name }}</p>
                <p>Opis: {{ description }}</p>
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

</style>
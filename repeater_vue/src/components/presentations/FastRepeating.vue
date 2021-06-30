<template>
<li>
    <router-link :to="'/repeating/' + courseId">
        <div>powtórki z kursu</div>
        <div>
            <p>{{ name }} - {{repAmount}}</p>
        </div>
        <hr>
    </router-link>
    
</li>
    
</template>

<script>
import http from '../../plugins/axios.js'

export default {
    name: 'FastRepeating',
    props: [
        'courseId',
        'name',
        'repAmount'
    ],
    data() {
        return {

        };
    },
    created(){
        this.getBatchForRepeat();
    },
    methods:{
        getBatchForRepeat(){
            //! zmienić tu limit na ten nowy dla fastRepeat
            let limit = this.$store.getters['repeat/getRepeatingBatchLimit'];
            //console.log('limit powtórek ze stora : ', limit)
            const url = "/repeatQueries/getRepeatBatchForCourse/" + this.courseId + "/" + limit;

            http.get(url)
            .then(response => {
                this.$store.dispatch('repeat/setBatchForRepeating', response.data);
                console.log('dane z requesta pobrania powtórek dla kursu:', response.data)
            })
            .then(()=>{
                //this.getLessonsFullInfo();
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

</style>
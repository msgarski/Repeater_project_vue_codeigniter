<template>
<li>
    <router-link :to="'/repeating/' + courseId">
        <div class="pasek">
            <div class="name-col">powtórki z kursu:</div><div class="name">{{ name }}</div>
        </div>
        <div class="pasek">
            <div class="name-col">liczba powtórek: </div><div class="name">{{repAmount}}</div>
        </div>
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
    li {
    margin: 1rem 0;
    border: 1px solid #424242;
    box-shadow: 3px 3px 3px 3px grey;
    border-radius: 12px;
    height: 65px;
}
.name {
    font-style: inherit;
    color: #3a0061;
    font-weight: bold;
    font-size: 20px;
    display: inline;
}
.name-col {
    font-style: inherit;
    display: inline;
    color: #3a0061;
    font-weight: bold;
    font-size: 14px;
    padding: 5px;
    float: left;
    margin-left: 10%;
}
.pasek {
    padding: 5px;
}
</style>
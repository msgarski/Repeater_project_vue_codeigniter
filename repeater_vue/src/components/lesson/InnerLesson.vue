<template>

<div class="container">
    <div>
        <!-- <h1>Wnętrze lekcji nr: {{ lessonId }}</h1> -->
        <h1 class="title">Temat lekcji: </h1>
    </div>
    <div class="button-tab">
        <div class="btn">
            <router-link :to="'/massimport/' + lessonId"><button class="button-1">Dodaj wiele kart</button></router-link>
        </div>
        <div class="btn">
            <router-link :to="'/singleimport/' + lessonId"><button class="button">Dodaj karty pojedynczo</button></router-link>
        </div>
    </div>
</div>
    
<div class="table-container">

    <div class="stats">
        <div class="stat">
            <div><label for="tryouts">Do nauki:</label></div>
            <div><p>15</p></div>
            <div><button class="button">Ucz się</button></div>
        </div>

        <div class="stat">
            <label for="repetitions">Do powtórki:</label>
            <p>7</p>
            <button class="button-1">Powtarzaj</button>
        </div>
    </div>
    


    <lesson-table :lessonId="lessonId"></lesson-table>

    <div class="btn-1">
        <!-- <a href="">Powrót do kursu</a> -->
        <button @click="backToPrevious" class="button">Powrót do widoku kursu</button>
    </div>
</div>

</template>

<script>
import http from '../../plugins/axios.js'
import LessonTable from './LessonTable.vue'

export default {
    name: 'inner-lesson',
    components: {
        'lesson-table'  :   LessonTable,
    },
    data(){
        return{
            lessonId: this.$route.params.lessonId,
            cards   :   null,
        };
    },
    created() {
        //his.getCardsForLesson();
    },
    methods: {
        backToPrevious: function(event){
            this.$router.go(-1);
           // alert('nic się nie stało')
        },
        getCardsForLesson(){
            http.get('cards/fillLessonTable/' + this.lessonId)
            .then((result) => {
                this.cards = result.data;

                
                console.log('widok słów do lekcji z http: ', this.cards[0].answer);
            })
            .then(()=>{
                
                this.$store.dispatch('learning/resetLoopNumber');
            })
            .catch((error) => {
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
    width: 95%;
    height: 60px;
    border: 1px solid grey(39, 39, 39);
    border-radius: 12px;
    box-shadow: 2px 2px 2px 2px grey;
    margin-top: 80px;
    margin-left: 2%;
    margin-right: auto;
    padding-bottom: 5px;
    padding-top: auto;
}
.table-container {
    position: absolute;
    width: 95%;
    border: 1px solid grey(39, 39, 39);
    border-radius: 12px;
    box-shadow: 2px 2px 2px 2px grey;
    margin-top: 160px;
    margin-left: 2%;
    margin-right: 100px;
}
.stats {
    color: grey;
    float: right;
    width: 30%;
    margin-right: 5%;
    margin-top: 45px;
    font-weight: bold;
    font-size: 18px;
    height: 200px;
    display: flex;
    min-height: 50vh;
    flex-direction: column;
}
label {
    display: block;
    font-size: 16px;
    padding-top: 15px;
}
p {
    display: block;
    font-size: 24px;
    font-weight: bold;
    padding-top: 10px;
}
.stats div {
    margin-top: 20px;
    
}
.stat {
    display: flex;
    justify-content:space-between;
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
    padding-right: 2%;
    padding-left: 30%;
    padding-top: 0px;
}
.form {
    padding-top: 40px;
    padding-bottom: 40px;
    padding-left: 40%;
    }
.button-container {
    display: flex;
    justify-content: flex-start;
    padding-bottom: 10px;
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
margin-top: 4px;
width: 150px;
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
width: 150px;
margin-top: 4px;
}
.btn {
    width: 100%;
    padding: 10px;
}
.btn-1 {
    width: 15%;
    padding-bottom: 10px;
    padding-right: 10px;
    margin-left: 80%;
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
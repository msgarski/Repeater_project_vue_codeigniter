<template>
<div class="container">
    <div>
        <h1 class="title">Edycja karty</h1>
    </div>
    <div class="del-btn">
        <div class="btn">
            <button @click="deleteCard(cardId)" class="button" id="btn-del">Usuń kartę</button>
        </div>
    </div>
    <form @submit.prevent="updateCard">
        <div>
            <div class="label">
                <label for="cardpriority">Nauka priorytetowa</label>
                <input type="checkbox" v-model="cardPriority" id="cardpriority" name="cardpriority">
            </div>
        </div>
        <div class="label">
            <label for="question" >Pytanie</label>
            <input type="text" name="question" v-model="question" id="question">
        </div>
        <div class="label">
            <label for="answer" >Odpowiedź</label>
            <input type="text" name="answer" v-model="answer" id="answer">
        </div>
        <div class="label">
            <label for="pronounciation">Wymowa</label>
            <input type="text" name="pronounciation" v-model="pronounciation" id="pronounciation">
        </div>
        <div class="label">
            <label for="sentence">Przykład użycia</label>
            <textarea rows="10" cols="100" name="sentence" v-model="sentence" id="sentence"></textarea>
        </div>
        <!-- <div>
            <label for="image">Dodaj obrazek</label>
            <input type="button" id="loadFile" value="Wybierz obrazek z dysku" onclick="document.getElementById('image').click();" />
            <input type="file" id="image" name="image" v-on:change="image" size="300"/>
        </div> -->

        <div>
                <!-- <input type="hidden" name="lesson_id" id="lesson_id"> -->
        </div>
        <div class="label">
            <div class="btn">
                <button class="button">Zapisz</button>
            </div>
            <div class="btn">
                <button @click="backToPrevious" class="button-1">Anuluj</button>
            </div>
        </div>
        
    
    </form>
    
</div>
    
</template>

<script>
import http from '../../plugins/axios.js'

export default {
    name: 'EditCard',
    data() {
        return {
            cardId  :   this.$route.params.cardId,
            cardPriority    :   '',
            question        :   '',
            answer          :   '',
            pronounciation  :   '',
            sentence        :   '',
            image           :   null

        };
    },
    created() { 
        this.fillEditForm()
    },
    methods: {
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
                //this.lessonsInfoIsLoaded = true;
                this.backToPrevious()
            })
            .catch(error => {
                this.errorMessage = error.message;
                console.error("coś poszło nie tak...", error);
            });
        },
        deleteCard(cardId){
            console.log('usuń kartę', cardId)
           this.eraseCardFromDatabase(cardId)
           this.getLessonsFullInfo();

        },
        eraseCardFromDatabase(cardId){
            http.get('cards/deleteCard/' + cardId)
            .then((result) => {
    
                console.log('widok słów do lekcji z http: ', result.data);
            })
            .then(()=>{
                //this.backToPrevious()
                //this.getCardsForLesson()
            })
            .catch((error) => {
                this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
            });
        },
        backToPrevious: function(event){
            this.$router.go(-1);
        },
        fillEditForm(){
            console.log('bież karta z eycji: ', this.cardId)
            let card = this.$store.getters['card/getCurrCard']
            this.cardPriority = card.priority  
            this.question       = card.question 
            this.answer         = card.answer
            this.pronounciation      = card.pronounciation
            this.sentence       = card.sentence
            this.image          = card.image

        },
        updateCard(){

            const card = this.$store.getters['card/getCurrCard']
            
            card.priority       =   this.cardPriority
            card.question       =   this.question
            card.answer         =   this.answer
            card.pronounciation  =   this.pronounciation
            card.sentence        =  this.sentence
            card.image           =   this.image
            
            //console.log('karta  do wysłania:', card)
            http.post('/cards/updateCard/' + this.cardId, card)
                .then(response=>{
                    console.log('odpowiedź serwera: ', response);
                })
                .then(()=>{
                    this.backToPrevious()
                    //alert('zapis udany!');
                })
                .catch(error => {
                    this.errorMessage = error.message;
                    console.error("nie udało się zapisać karty...", error);
                });
        }
    }
}
</script>

<style scoped>
    .container {
    position: absolute;
    border: 1px solid grey(39, 39, 39);
    border-radius: 12px;
    box-shadow: 5px 5px 5px 5px grey;
    width: 80%;
    margin-top: 80px;
    margin-left: 10%;
    margin-right: 10%;
}
.inputses {
    display: flex;
    justify-content: space-between;
}
.button-container {
    position: relative;
    border: 1px solid grey(39, 39, 39);
    border-radius: 12px;
    box-shadow: 5px 5px 5px 5px grey;
    width: 80%;
    margin-top: 110px;
    margin-left: 10%;
    margin-right: 100px;
}
.title {
    margin-top: 0px;
    position: relative;
    text-align: center;
    color: gray;
    font-weight: bold;
    font-size: 25px;
    margin-left: 10px;
    margin-top: 5px;
    }
form {
    padding-top: 20px;
    padding-bottom: 30px;
    padding-left: 25%;
    padding-right: 30%;
    }
label {
    display: block;
    font-size: 16px;
    font-style: italic;
    padding-top: 15px;
    }
.label {
    display: flex;
    justify-content: space-between;
    height: 40px;

}
input {
    width: 50%;
    padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border-radius: 5px;
}
textarea {
    width: 50%;
    padding: 12px 20px;
    border-width: 2px;
  margin: 8px 0;
  box-sizing: border-box;
  border-radius: 5px;
}
#genre {
    width: 30%;
    padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border-radius: 5px;

  border-width: 2px;
}
.button {
background-color: #ffae00; /* Green */
font-weight: bold;
border: none;
color: white;
text-align: center;
text-decoration: none;
font-size: 14px;
width: 120px;
height: 40px;
border-radius: 20px;
margin-left: 40%;
}
#btn-del {
    background-color: red;
    margin-left: 43%;
}
.button-1 {
background-color: #718bff; /* Green */
font-weight: bold;
margin-left: 100px;
border: none;
color: white;
text-align: center;
text-decoration: none;
font-size: 14px;
height: 40px;
border-radius: 20px;
width: 120px;
margin-left: 47%;
}
.btn {
    width: 100%;
    padding: 20px;
}
a {
    color: white;
}
</style>
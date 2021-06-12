<template>
    <div>
        <h1>Edycja karty</h1>
    </div>

    <form @submit.prevent="updateCard">
        <div>
            <div>
                <label for="cardpriority">Nauka priorytetowa</label>
                <input type="checkbox" v-model="cardPriority" id="cardpriority" name="cardpriority">
            </div>
        </div>
<div>
    <label for="question" >Pytanie</label>
    <input type="text" name="question" v-model="question" id="question">
</div>
<div>
    <label for="answer" >Odpowiedź</label>
    <input type="text" name="answer" v-model="answer" id="answer">
</div>
<div>
    <label for="pronounciation">Wymowa</label>
    <input type="text" name="pronounciation" v-model="pronounciation" id="pronounciation">
</div>
<div>
    <label for="sentence">Przykład użycia</label>
    <input type="text" name="sentence" v-model="sentence" id="sentence">
</div>
<div>
    <label for="image">Dodaj obrazek</label>
    <!-- <input type="button" id="loadFile" value="Wybierz obrazek z dysku" onclick="document.getElementById('image').click();" /> -->
    <input type="file" id="image" name="image" v-on:change="image" size="300"/>
</div>

<div>
        <!-- <input type="hidden" name="lesson_id" id="lesson_id"> -->
</div>

<button>Zapisz</button>
    </form>
    <div>
    <button @click="backToPrevious">Anuluj</button>
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

</style>
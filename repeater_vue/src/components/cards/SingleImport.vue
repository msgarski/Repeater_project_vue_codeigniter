<template>
<div><p>
    id lekcji: {{lessonId}}
    </p>
</div>
    <form @submit.prevent="addCard">
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
    data(){
        return {
            lessonId: this.$route.params.lessonId,
            question    :'',
            answer      :'',
            pronounciation:'',
            sentence    :'',
            image       :null,
            cardPriority    :''
        };
    },
    setup() {
        
    },
    methods: {
        backToPrevious: function(event){
            this.$router.go(-1);
        },
        addCard(){
            const pack = {
                lessonId    :   this.lessonId,
                question    :   this.question,
                answer      :   this.answer,
                pronounciation: this.pronounciation,
                sentence    :   this.sentence,
                image       :   this.image,
                priority    :   this.cardPriority,
                userId      :   this.$store.getters.getUserId,
                token       :   localStorage.getItem('token')
            }
            console.log('lesson id:', pack.lessonId)

            http.post('/cards/createCard', pack)
                .then(response=>{
                    console.log('odpowiedź serwera: ', response);
                })
                .then(()=>{
                    //this.$router.push('/mainscreen')
                    alert('zapis udany!');
    
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

<template>
    <p>Wprowadź listę słów:</p>
    <div>numer lekcji: {{lessonId}}</div>
<form @submit.prevent="addCards">
<div>
    <label for="cardsInput"></label>
    <textarea rows="10" cols="100" name="cardsInput" v-model="cardsImport" id="cardsInput" 
    placeholder="pytanie odpowiedź [wymowa] [zdanie przykładowe]"></textarea>
</div>

<div>
    <label for="reckon">wykrywaj znaki rozdzielające</label>
    <input type="checkbox" name="reckon" id="reckon" checked>
</div>

<div>
        <input type="hidden" name="lesson_id" id="lesson_id">
</div>

<button>Zapisz</button>

</form>
</template>

<script>
import http from '../../plugins/axios.js'

export default {
    data(){
        return{
            lessonId: this.$route.params.lessonId,
            cardsImport: '',
            cardsPriority: ''
        };
    },
    setup() {
        
    },
    methods: {
        addCards(){
            // const pack = {
            //     lessonId    :   this.lessonId,
            //     question    :   this.question,
            //     answer      :   this.answer,
            //     pronounciation: this.pronounciation,
            //     sentence    :   this.sentence,
            //     image       :   this.image,
            //     userId      :   this.$store.getters.getUserId,
            //     token       :   localStorage.getItem('token')
            // }
            const pack = {
                cardsInput  :   this.cardsImport,
                priority    :   this.cardsPriority,
                lessId      :   this.lessonId,
                userId      :   this.$store.getters.getUserId,
                token       :   localStorage.getItem('token')
            }
            console.log('lesson id:', pack.lessId)

            http.post('/cards/createManyCards', pack)
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
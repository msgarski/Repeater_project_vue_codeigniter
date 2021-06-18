<template>

    <div class="container">
        <p class="title">Wprowadź listę słów:</p>
            <!-- <div>numer lekcji: {{lessonId}}</div> -->
        <form @submit.prevent="addCards">
            <div>
                <div class="label">
                    <label for="cardpriority">Nauka priorytetowa</label>
                    <input type="checkbox" v-model="cardsPriority" id="cardpriority" name="cardpriority">
                </div>
            </div>
            <div>
                <label for="cardsInput"></label>
                <textarea rows="16" cols="300" name="cardsInput" v-model="cardsImport" id="cardsInput" 
                placeholder="pytanie odpowiedź [wymowa] [zdanie przykładowe]"></textarea>
            </div>

            <div class="label">
                <label for="reckon">wykrywaj znaki rozdzielające</label>
                <input type="checkbox" name="reckon" id="reckon" checked>
            </div>

            <div>
                <input type="hidden" name="lesson_id" id="lesson_id">
            </div>
            <div class="btn">
                <button class="button">Zapisz</button>
            </div>
            
        </form>
        <div class="btn"> 
            <button @click="backToPrevious" class="button-1">Anuluj</button>
        </div>
    </div>
    
</template>

<script>
import http from '../../plugins/axios.js'

export default {
    data(){
        return{
            lessonId: this.$route.params.lessonId,
            cardsImport: '',
            cardsPriority: false
        };
    },
    setup() {
        
    },
    methods: {
        backToPrevious: function(event){
            this.$router.go(-1);
        },
        addCards(){
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
    .container {
    position: absolute;
    border: 1px solid grey(39, 39, 39);
    border-radius: 12px;
    box-shadow: 5px 5px 5px 5px grey;
    width: 90%;
    margin-top: 80px;
    margin-left: 5%;
    margin-right: 5%;
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
    margin-top: 20px;
    }
form {
    width: 100%;
    padding-top: 40px;
    padding-bottom: 40px;
    padding-left: 0%;
    padding-right: 0%;  
    margin-left: 25%;  }
textarea {
    width: 90%;
    }
label {
    display: block;
    font-size: 16px;
    font-style: italic;
    }
.label {
    display: flex;
    justify-content: space-between;
    margin-right: 50%;
    margin-left: 10%;
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
width: 30%;
height: 40px;
border-radius: 20px;
margin-left: 10%;
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
width: 80px;
margin-left: 48%;
margin-bottom: 10px;
}
#btn {
    width: 100%;
    float: left;
    padding: 5px;
}
a {
    color: white;
}
</style>